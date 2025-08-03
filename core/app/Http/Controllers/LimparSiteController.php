<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LimparSiteController extends Controller
{
    public function limparLogs()
    {
        $relatorio = [
            'tabelas_limpas' => [],
            'arquivos_apagados' => [
                'log_laravel' => [],
                'views' => [],
                'cache' => [],
                'sessoes' => []
            ]
        ];


        $tabelas = [
            'admin_notifications',
            'admin_password_resets',
            'email_logs',
            'password_resets',
            'user_logins'
        ];

        foreach ($tabelas as $tabela) {
            DB::table($tabela)->truncate();
            $relatorio['tabelas_limpas'][] = $tabela;
        }


        $logPath = storage_path('logs/laravel.log');
        if (file_exists($logPath)) {
            $relatorio['arquivos_apagados']['log_laravel'][] = $logPath;
            @unlink($logPath);
            @touch($logPath);
        }

        $pastas = [
            'views' => storage_path('framework/views'),
            'cache' => storage_path('framework/cache/data'),
            'sessoes' => storage_path('framework/sessions')
        ];

        foreach ($pastas as $tipo => $dir) {
            if (is_dir($dir)) {
                $relatorio['arquivos_apagados'][$tipo] = $this->limparConteudoDiretorio($dir);
            }
        }

        return response()->json([
            'status' => 'Limpeza concluída com sucesso!',
            'relatorio' => $relatorio
        ]);
    }

    private function limparConteudoDiretorio(string $dir): array
    {
        $apagados = [];

        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($dir, \FilesystemIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::CHILD_FIRST
        );

        foreach ($iterator as $item) {
            $path = $item->getRealPath();
            if ($item->isFile()) {
                $apagados[] = $path;
                @unlink($path);
            } elseif ($item->isDir()) {
                $apagados[] = $path;
                @rmdir($path);
            }
        }

        return $apagados;
    }
}
