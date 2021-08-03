@php
    $setModalTitle = $title ?? null;
    $setPrefix = 'macf-';

    $setModalType = 'default';
    if(isset($modalType) && in_array($modalType, ['sm', 'md', 'lg', 'xl'])){
        $setModalType = $modalType;
    }

    if($setModalType !== 'default'){
        $setModalType = 'modal-'.$setModalType;
    }else {
        $setModalType = 'modal-full';
    }

    $setBtnIdentify = $setPrefix.'button';
    if(isset($btnIdentify) && $btnIdentify){
        $setBtnIdentify = $setPrefix.$btnIdentify.'-button';
    }

    $setModalIdentify = $setBtnIdentify.'-modal';

    $varBtn = Str::camel($setBtnIdentify);
    $varModal = Str::camel($setModalIdentify);


    $action_form = $action_form ?? 'create';
    $labelButtonCreate = $labelButtonCreate ?? trans('flexi.create');
    $labelButtonUpdate = $labelButtonUpdate ?? trans('flexi.update');

    $setModelFooter = $setModelFooter ?? '';
    $setModalPosition = $setModalPosition ?? '';
    $modalBody = $modalBody ?? '';
@endphp

@if (isset($btnLayout) && $btnLayout)
    {!! $btnLayout !!}
@else
    <button type="button" class="{{ $btn_class ?? 'btn btn-primary' }} {{ $setBtnIdentify }}" id="{{ $setBtnIdentify }}" @click="openModal" data-action-form="{{ $action_form }}">
        <i class="fa {{ $btn_icon }}" ></i>{{ $btn_label }}
        <i class="la la-spinner fa-pulse fa-lg fa-fw"></i>
    </button>
@endif

@push('after_scripts')
    <div class="modal {{ $setModalIdentify }}" tabindex="-1" role="dialog" id="{{ $setModalIdentify }}">
        <div class="modal-dialog h-auto {{ $setModalPosition }} {{ $setModalType }}" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" @click="cancel">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body {{ $modalBody }}">
                    <form method="post"
                        :action="getRoute"
                        enctype="multipart/form-data"
                        ref="formCreate"
                    >
                        @csrf
                        {!! $view !!}
                    </form>
                </div>
                <div class="modal-footer {{ $setModelFooter }}">
                    <button
                        :disabled="isSubmitting"
                        type="button"
                        class="btn btn-primary"
                        @click="store"
                        v-if="getActionForm == 'create'"
                    >{{ $labelButtonCreate }}</button>

                    <button
                        :disabled="isSubmitting"
                        type="button"
                        class="btn btn-success"
                        @click="store"
                        v-if="getActionForm == 'update'"
                    >{{ $labelButtonUpdate }}</button>

                    <button
                        type="button"
                        class="btn btn-secondary"
                        @click="cancel"
                        v-html="getActionForm == 'show' ? '{{trans('flexi.close')}}' : '{{trans('cancel')}}'"
                    ></button>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ mix('js/app.js') }}" type="text/javascript"></script>
    <script>
        var {{ $varBtn }} = new Vue({
            el: '#{{ $setBtnIdentify }}',
            data: function() {
                return {
                    isLoading: false
                }
            },
            methods: {
                openModal: async function() {
                    await {{ $varModal }}.isModalDoneLoading();
                }
            },
        })

        var {{ $varModal }} = new Vue({
            el: '#{{ $setModalIdentify }}',
            data: function () {
                return{
                    isLoading: false,
                    serverTitle: '{{ $setModalTitle }}',
                    onTitle: '',
                    serverRoute: '{{ $route }}',
                    onChangeRoute: '',
                    serverActionForm: '{{ $action_form }}',
                    onActionForm: '',
                    btnEditId: '',
                    result: null,
                    dataAttr: {},
                    lists: @json($lists ?? []),
                    isSubmitting: false
                }
            },
            mounted: function () {
                const vm = this;
                $(vm.$el).on('hidden.bs.modal', function(e){
                    vm.cancel();
                })
                console.log(this.$refs)
            },
            computed:{
                getRoute: function(){
                    if(this.onChangeRoute){
                        return this.onChangeRoute
                    }
                    return this.serverRoute
                },
                getTitle: function () {
                    if (this.onTitle) {
                        return this.onTitle
                    }
                    return this.serverTitle
                },
                getActionForm: function () {
                    if (this.onActionForm) {
                        return this.onActionForm
                    }
                    return this.serverActionForm
                },
            },
            methods: {
                toggleModal: function(type = 'toggle'){
                    switch(type){
                        case 'close': $(this.$el).modal('hide'); break;
                        case 'open' : $(this.$el).modal('show'); break;
                        default: $(this.$el).modal(type)
                    }
                },
                isModalDoneLoading: async function(){
                    this.dataAttr = {};
                    this.onChangeRoute = ''
                    this.onActionForm = ''
                    this.onTitle = false
                    this.toggleModal()
                },
                cancel: function(){
                    const form = this.$refs.formCreate;
                    const jqForm = $(form);

                    @if (isset($modalCancel) && $modalCancel)
                        {!! $modalCancel !!}
                    @else
                        this.toggleModal('close')
                        // if((this.getActionForm == 'create')){
                        //     rmResetBasicForm(jqForm);
                        // }
                    @endif

                },
                store: function(){
                    const form = this.$refs.formCreate;
                    const jqForm = $(form);
                    this.isSubmitting = true;
                    const formData = new FormData(form);

                    {{ $formData ?? '' }}

                    axios.post(this.getRoute, formData).then(res=>{
                        this.result = res.data;
                        console.log(this.result)

                        // @if (isset($axiosThen) && $axiosThen)
                        //     {!! $axiosThen !!}
                        // @else
                        //     // rmAlert('{{ trans('flexi.save_successfully') }}')
                        //     if(this.getActionForm == 'create'){
                        //         reResetBasicForm(jqForm);
                        //     }

                        //     this.toggleModal('close')
                        // @endif
                    }).catch(e=>{
                        console.log(e)
                        // @if (isset($axiosCatch))
                        //     {!! $axiosCatch !!}
                        // @else
                        //     this.isSubmitting = false
                        //     rmAlert('{{trans('flexi.please_correct_information')}}', 'warning')
                        //     rmCatchValidateMessageError(e, jqForm);
                        // @endif
                    })
                },
                // setDataEntry: function (result) {
                //     const entry = rmIsObject(this.dataAttr, 'entry')
                //     if (entry && Object.keys(entry).length) {

                //         $('#' + this.btnEditId).attr('data-entry', JSON.stringify(result))
                //         this.$set(this.dataAttr, 'entry', result)
                //     }
                // },
            },
        })
    </script>
@endpush
