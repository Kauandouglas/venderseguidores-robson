
<!-- Modal -->
<div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Termos & Condições</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">{!! nl2br($systemSetting->terms ?? '') !!}</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>


<div class="copyright bg-gray mt-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <ul class="list-unstyled li-space-lg p-small">
                    <li><a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">Termos & Condições</a></li>
                </ul>
            </div>
            <div class="col-lg-6">
                <p class="p-small statement">Copyright ©
                    <a href="{{ route('web.systemSettings.template', ['domain' => $user->domain]) }}">{{ $systemSetting->title ?? config('template.title')}}</a>
                    | Todos os direitos reservados</p>
            </div>
        </div>
    </div>
</div>
