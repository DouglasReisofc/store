<?php

namespace App\Http\Controllers;
use App\Models\AdminNotification;
use App\Models\Frontend;
use App\Models\Language;
use App\Models\Page;
use App\Models\SupportAttachment;
use App\Models\SupportMessage;
use App\Models\SupportTicket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Card;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class SiteController extends Controller
{
    public function __construct(){
        $this->activeTemplate = activeTemplate();
    }

    public function index(){
        $count = Page::where('tempname',$this->activeTemplate)->where('slug','home')->count();
        if($count == 0){
            $page = new Page();
            $page->tempname = $this->activeTemplate;
            $page->name = 'HOME';
            $page->slug = 'home';
            $page->save();
        }

        $reference = @$_GET['reference'];
        if ($reference) {
            session()->put('reference', $reference);
        }

        $pageTitle = 'Home';
        $sections = Page::where('tempname',$this->activeTemplate)->where('slug','home')->first();
        return view($this->activeTemplate . 'home', compact('pageTitle','sections'));
    }

    public function pages($slug)
    {
        $page = Page::where('tempname',$this->activeTemplate)->where('slug',$slug)->firstOrFail();
        $pageTitle = $page->name;
        $sections = $page->secs;
        return view($this->activeTemplate . 'pages', compact('pageTitle','sections'));
    }


    public function contact()
    {
        $pageTitle = "Contact Us";
        return view($this->activeTemplate . 'contact',compact('pageTitle'));
    }


    public function contactSubmit(Request $request)
{
    // Primeiro, valide os campos do formulário excluindo a validação do reCAPTCHA
    $this->validate($request, [
        'name' => 'required|max:191',
        'email' => 'required|max:191',
        'subject' => 'required|max:100',
        'message' => 'required',
    ]);

    // Agora, valide o reCAPTCHA da mesma forma que você fez no método de registro
    if (isset($request->captcha)) {
        if (!captchaVerify($request->captcha, $request->input('captcha_secret'))) {
            $notify[] = ['error', "Captcha inválido"];
            return back()->withNotify($notify)->withInput();
        }
    } else {
        // Se o captcha não estiver presente no pedido, retorne um erro.
        $notify[] = ['error', "Captcha é necessário"];
        return back()->withNotify($notify)->withInput();
    }


        $random = getNumber();

        $ticket = new SupportTicket();
        $ticket->user_id = auth()->id() ?? 0;
        $ticket->name = $request->name;
        $ticket->email = $request->email;
        $ticket->priority = 2;


        $ticket->ticket = $random;
        $ticket->subject = $request->subject;
        $ticket->last_reply = Carbon::now();
        $ticket->status = 0;
        $ticket->save();

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = auth()->user() ? auth()->user()->id : 0;
        $adminNotification->title = 'Um novo ticket de suporte foi aberto ';
        $adminNotification->click_url = urlPath('admin.ticket.view',$ticket->id);
        $adminNotification->save();

        $message = new SupportMessage();
        $message->supportticket_id = $ticket->id;
        $message->message = $request->message;
        $message->save();

        $notify[] = ['success', 'ticket criado com sucesso!'];

        return redirect()->route('ticket.view', [$ticket->ticket])->withNotify($notify);
    }

    public function changeLanguage($lang = null)
    {
        $language = Language::where('code', $lang)->first();
        if (!$language) $lang = 'en';
        session()->put('lang', $lang);
        return redirect()->back();
    }

    public function blogDetails($slug, $id){
        $blog = Frontend::where('id',$id)->where('data_keys','blog.element')->firstOrFail();
        $blog->increment('view');
        $blog->save();

        $latestBlogs = Frontend::where('data_keys','blog.element')->latest()->take(5)->get();
        $topBlogs = Frontend::where('data_keys','blog.element')->orderBy('view', 'DESC')->take(5)->get();

        $pageTitle = $blog->data_values->title;
        return view($this->activeTemplate.'blog_details',compact('blog','pageTitle', 'latestBlogs', 'topBlogs'));
    }

    public function blogs(){
        $pageTitle = 'All Blog';
        $blogs = Frontend::where('data_keys','blog.element')->latest()->paginate(getPaginate());
        return view($this->activeTemplate.'blogs',compact('blogs','pageTitle'));
    }

    public function cookieAccept(){
        session()->put('cookie_accepted',true);
        $notify[] = ['success','Cookie aceito com sucesso'];
        return back()->withNotify($notify);
    }

    public function placeholderImage($size = null){
        $imgWidth = explode('x',$size)[0];
        $imgHeight = explode('x',$size)[1];
        $text = $imgWidth . '×' . $imgHeight;
        $fontFile = realpath('assets/font') . DIRECTORY_SEPARATOR . 'RobotoMono-Regular.ttf';
        $fontSize = round(($imgWidth - 50) / 8);
        if ($fontSize <= 9) {
            $fontSize = 9;
        }
        if($imgHeight < 100 && $fontSize > 30){
            $fontSize = 30;
        }

        $image     = imagecreatetruecolor($imgWidth, $imgHeight);
        $colorFill = imagecolorallocate($image, 100, 100, 100);
        $bgFill    = imagecolorallocate($image, 175, 175, 175);
        imagefill($image, 0, 0, $bgFill);
        $textBox = imagettfbbox($fontSize, 0, $fontFile, $text);
        $textWidth  = abs($textBox[4] - $textBox[0]);
        $textHeight = abs($textBox[5] - $textBox[1]);
        $textX      = ($imgWidth - $textWidth) / 2;
        $textY      = ($imgHeight + $textHeight) / 2;
        header('Content-Type: image/jpeg');
        imagettftext($image, $fontSize, 0, $textX, $textY, $colorFill, $fontFile, $text);
        imagejpeg($image);
        imagedestroy($image);
    }

    public function policyPage($slug, $id){
        $content = Frontend::where('data_keys','policy_pages.element')->where('id', $id)->firstOrFail();
        $pageTitle = $content->data_values->title;
        return view($this->activeTemplate.'policy_page',compact('content','pageTitle'));
    }



    public function card()
    {
        $pageTitle = 'Cards';
        $extends = Auth::user() ? $this->activeTemplate.'layouts.master' : $this->activeTemplate.'layouts.frontend';
    
        // Obtém todas as categorias, assegurando que todas as propriedades necessárias estejam sendo selecionadas.
        $categories = DB::table('categories')
                        ->select('id', 'name', 'order') // Assegura que 'name' esteja incluído.
                        ->orderBy('order', 'asc')
                        ->get();
    
        foreach ($categories as &$category) {
            // Assegura que 'name', 'image' e outras propriedades necessárias das subcategorias estejam sendo selecionadas.
            $subCategories = DB::table('sub_categories')
                                ->select('id', 'category_id', 'name', 'order', 'image', 'price') // Incluindo 'image' e 'value' na seleção.
                                ->where('category_id', $category->id)
                                ->orderBy('order', 'asc')
                                ->get();
    
            foreach ($subCategories as &$subCategory) {
                // Realiza a contagem de cartões disponíveis conforme explicado anteriormente.
                $subCategory->totalAvailableCards = DB::table('cards')
                    ->where('sub_category_id', $subCategory->id)
                    ->where(function($query) {
                        $query->where(function($q) {
                            $q->where('user_id', 0)
                              ->where('revender', 0);
                        })
                        ->orWhere(function($q) {
                            $q->where('revender', 1); // Assumindo que 'disponivel' representa a quantidade para revenda.
                        });
                    })
                    ->sum(DB::raw('CASE WHEN revender = 1 THEN disponivel ELSE 1 END'));
    
                // Nota: A carga direta dos detalhes dos cards foi removida para prevenir a exposição de informações sensíveis antes da compra.
            }
    
            $category->subCategories = $subCategories;
        }
    
        return view($this->activeTemplate.'card', compact('pageTitle', 'categories', 'extends'));
    }
    
    

    

    



public function category($name, $id)
{
    $pageTitle = ucfirst($name);

    // Aqui garantimos que apenas as subcategorias dessa categoria específica sejam carregadas,
    // juntamente com seus cards, todos ordenados.
    $subCategories = SubCategory::where('category_id', $id)
        ->with(['cards' => function($query) {
            $query->orderBy('order', 'asc');
        }])->orderBy('order', 'asc')->paginate(getPaginate());

    $extends = Auth::user() ? $this->activeTemplate.'layouts.master' : $this->activeTemplate.'layouts.frontend';

    return view($this->activeTemplate.'card', compact('pageTitle', 'subCategories', 'extends'));
}


    public function cardDetails($name, $id) {
        $name = str_replace('-', ' ', $name);
    
        $subCategory = SubCategory::where('id', $id)
            ->where('name', $name)
            ->whereHas('category', function ($q) {
                $q->where('status', 1);
            })
            ->first();
    
        \Log::info('Nome fornecido: ' . $name);
        \Log::info('Resultado da consulta: ' . json_encode($subCategory));
    
        if (!$subCategory) {
            \Log::warning('SubCategory não encontrada');
            return redirect()->route('card');
        }
    
        $pageTitle = ucfirst($name);
        $extends = Auth::user() ? $this->activeTemplate . 'layouts.master' : $this->activeTemplate . 'layouts.frontend';
    
        return view($this->activeTemplate . 'card_details', compact('pageTitle', 'subCategory', 'extends'));
    }







}
