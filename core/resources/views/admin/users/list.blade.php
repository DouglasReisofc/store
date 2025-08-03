@extends('admin.layouts.app')

@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                            <tr>
                                <th>@lang('User')</th>
                                <th>@lang('Email-Phone')</th>
                                <th>@lang('Country')</th>
                                <th>@lang('Joined At')</th>
                                <th>@lang('Balance')</th>
                                <th>@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($users as $user)
                                <tr>
                                    <td data-label="@lang('User')">
                                        <span class="font-weight-bold">{{$user->fullname}}</span>
                                        <br>
                                        <span class="small">
                                            <a href="{{ route('admin.users.detail', $user->id) }}"><span>@</span>{{ $user->username }}</a>
                                        </span>
                                    </td>

                                    <td data-label="@lang('Email-Phone')">
                                        {{ $user->email }}<br>{{ $user->mobile }}
                                    </td>
                                    <td data-label="@lang('Country')">
                                        <span class="font-weight-bold" data-toggle="tooltip" data-original-title="{{ @$user->address->country }}">{{ $user->country_code }}</span>
                                    </td>

                                    <td data-label="@lang('Joined At')">
                                        {{ showDateTime($user->created_at) }} <br> {{ diffForHumans($user->created_at) }}
                                    </td>

                                    <td data-label="@lang('Balance')">
                                        <span class="font-weight-bold">{{ $general->cur_sym }}{{ showAmount($user->balance) }}</span>
                                    </td>

                                    <td data-label="@lang('Action')">
    <a href="{{ route('admin.users.detail', $user->id) }}" class="icon-btn" data-toggle="tooltip" title="" data-original-title="@lang('Details')">
        <i class="fas fa-desktop text--shadow mr-2"></i>
    </a>
    <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteUserModal{{ $user->id }}">
        <i class="fas fa-trash-alt ml-2"></i>
    </button>
    <!-- Delete User Modal -->
    <div class="modal fade" id="deleteUserModal{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteUserModalLabel">Apagar Usuário</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><b>Você Tem certeza que deseja Apagar este Usuário do Painel ?<br> Essa Ação Não poderá Ser desfeita e Todos os dados dele serão Removidos do sistema</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <form action="{{ route('admin.users.delete', $user->id) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Delete User Modal -->
</td>

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
                <div class="card-footer py-4">
                </div>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <form action="{{ route('admin.users.search', $scope ?? str_replace('admin.users.', '', request()->route()->getName())) }}" method="GET" class="form-inline float-sm-right bg--white">
        <div class="input-group has_append">
            <input type="text" name="search" class="form-control" placeholder="@lang('Username or email')" value="{{ $search ?? '' }}">
            <div class="input-group-append">
                <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </form>
@endpush
