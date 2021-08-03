<!-- select -->
{{-- <div class="#app"> --}}
@php
$setRequired = $field['setRequired'] ?? 0;
$requireCity = $setRequired >= 2;
$requireDistrict = $setRequired >= 4;
$requireConmmune = $setRequired >= 6;
$requireVillage = $setRequired >= 8;
$uniqueId = 'address-' . Str::uuid();
$colMd12 = 'form-group col-md-12 mb-0';
$attribute = '';

if (array_key_exists('wrapper', $field)) {
    $colMd12 .= array_key_exists('class', $field['wrapper']) ? ' ' . $field['wrapper']['class'] : '';
    $attribute = array_key_exists('data-lead-type', $field['wrapper']) ? $field['wrapper']['data-lead-type'] : '';
}
$select2Class = 'address_old_select2';

@endphp

{{-- field type name --}}

<div class="{{ $colMd12 }}"
    @if ($attribute) data-lead-type="{{ $attribute }}" @endif>
    <div class="row"
        id="{{ $uniqueId }}">
        <div class="col-sm-6 col-md-6 mb-3">
            <label :class="[!error.city ? 'no-error-label' : '']">Province/City @if ($setRequired >= 2) <span class="label-required">*</span> @endif
            </label>
            <select class="form-control {{ $select2Class }} city_select select2-hidden-accessible"
                :class="error && error.city ? '@if ($errors->first($field['name']) && $requireCity) border-danger is-invalid @endif' : ''"
                @change="cityChange"
                v-model="frm.city"
                :disabled="JSON.stringify(cities).length == 2"
                @if (isset($field['disable_input']) && $field['disable_input'])
                    disabled="disabled"
                @endif >

                <option v-for="(val, text) in cities" :value="val">@{{ text }}</option>
            </select>
            <div v-if="error && error.city"
                class="invalid-feedback d-block">
                @{{ error.city }}
            </div>
        </div>
        <div class="col-sm-6 col-md-6 mb-3">
            <label :class="[!error.distric ? 'no-error-label' : '']">District/Khan @if ($setRequired >= 2) <span class="label-required">*</span> @endif
            </label>
            <select class="form-control {{ $select2Class }} distric_select select2-hidden-accessible"
                :class="error && error.distric ? '@if ($errors->first($field['name']) && $requireDistrict) border-danger is-invalid @endif' : ''"
                @change="districChange"
                v-model="frm.distric"
                id="distric_select"
                :disabled="JSON.stringify(districs).length == 2"
                @if (isset($field['disable_input']) && $field['disable_input'])
                    disabled="disabled"
                @endif >

                <option v-for="(val, text) in districs" :value="val">@{{ text }}</option>
            </select>
            <div v-if="error && error.distric"
                class="invalid-feedback d-block">
                @{{ error.distric }}
            </div>
        </div>
        <div class="col-sm-6 col-md-6 mb-3">
            <label :class="[!error.commune ? 'no-error-label' : '']">Commune @if ($setRequired >= 2) <span class="label-required">*</span> @endif
            </label>
            <select class="form-control {{ $select2Class }} commune_select select2-hidden-accessible"
                :class="error && error.commune ? '@if ($errors->first($field['name']) && $requireCommune) border-danger is-invalid @endif' : ''"
                @change="communeChange"
                v-model="frm.commune"
                :disabled="JSON.stringify(communes).length == 2"
                @if (isset($field['disable_input']) && $field['disable_input'])
                    disabled="disabled"
                @endif >

                <option v-for="(val, text) in communes" :value="val">@{{ text }}</option>
            </select>
            <div v-if="error && error.commune"
                class="invalid-feedback d-block">
                @{{ error.commune }}
            </div>
        </div>
        <div class="col-sm-6 col-md-6 mb-3">
            <label :class="[!error.village ? 'no-error-label' : '']">Village @if ($setRequired >= 2) <span class="label-required">*</span> @endif
            </label>
            <select class="form-control {{ $select2Class }} village_select select2-hidden-accessible"
                :class="error && error.village ? '@if ($errors->first($field['name']) && $requireVillage) border-danger is-invalid @endif' : ''"
                @change="villageChange"
                v-model="frm.village"
                :disabled="JSON.stringify(villages).length == 2"
                @if (isset($field['disable_input']) && $field['disable_input'])
                    disabled="disabled"
                @endif >

                <option v-for="(val, text) in villages" :value="val">@{{ text }}</option>
            </select>
            <div v-if="error && error.village"
                class="invalid-feedback d-block">
                @{{ error.village }}
            </div>
        </div>
        <input type="hidden" v-model="hidden" name="{{ $field['name'] }}">
    </div>

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
</div>

@if ($crud->checkIfFieldIsFirstOfItsType($field, $fields))
    {{-- FIELD EXTRA CSS --}}
    {{-- push things in the after_styles section --}}

    @push('crud_fields_styles')
        <!-- no styles -->
        {{-- Remove style and class when enable all field show error --}}
        <style>
            .label-required {
                color: #ff0000;
            }

            .no-error-border {
                border-color: #d2d6de !important;
            }

            .no-error-label {
                color: #333 !important;
            }

            #{{ $uniqueId }}+.invalid-feedback {
                display: none !important;
            }

        </style>
    @endpush
    {{-- FIELD EXTRA JS --}}
    {{-- push things in the after_scripts section --}}
    @push('crud_fields_scripts')
        <script src="{{ asset('packages/select2/dist/js/select2.full.min.js') }}"></script>
        @if (app()->getLocale() !== 'en')
            <script src="{{ asset('packages/select2/dist/js/i18n/' . app()->getLocale() . '.js') }}"></script>
        @endif
        <script>
            @if (isset($field['setScriptName'])) var {{ $field['setScriptName'] }} =@endif new Vue({
                el: '#{{ $uniqueId }}',
                data: {
                    cities: {},
                    districs: {},
                    communes: {},
                    villages: {},
                    error: {},
                    frm: {},
                    hidden: "{{ old($field['name']) ? old($field['name']) : (isset($field['value']) ? $field['value'] : (isset($field['default']) ? $field['default'] : '')) }}",
                    loadingHidden: {}
                },
                methods: {
                    getData: function(code = '') {
                        if (code) {
                            return axios.get('{{ route('web-api.address.index') }}??code=' + code)
                        } else {
                            return axios.get('{{ route('web-api.address.index') }}')
                        }
                    },
                    loadAddress: async function(val) {
                        await this.getData().then(res => {
                            this.cities = res.data;
                        });
                        if (val.length > 1) {
                            var str = val;
                            var take = 2;
                            var i = 1;

                            do {
                                var res = str.substring(0, take * i);
                                if (i == 1) {
                                    this.frm.city = res;
                                    await this.cityChange();
                                }
                                if (i == 2) {
                                    this.frm.distric = res;
                                    await this.districChange();
                                }
                                if (i == 3) {
                                    this.frm.commune = res;
                                    await this.communeChange();
                                }
                                if (i == 4) {
                                    this.frm.village = res;
                                    await this.villageChange();
                                }
                                $('.{{ $select2Class }}').trigger('change');
                                i++;
                            } while (res != str);
                        }
                    },
                    cityChange: async function() {
                        this.hidden = this.frm.city;
                        this.districs ={};
                        await this.getData(this.frm.city).then(res=>{
                            this.districs = res.data;
                            this.communes={};
                            this.villages={};
                        });
                    },
                    districChange: async function(){
                        var me = this;
                        this.hidden = this.frm.distric;
                        me.communes={};
                        await this.getData(this.frm.distric).then(function(response){
                            me.communes = response.data;
                            me.villages={};
                        });
                    },
                    communeChange: async function() {
                        this.hidden = this.frm.commune;
                        this.villages = {};
                        await this.getData(this.frm.commune).then(res=>{
                            this.villages = res.data;
                        })
                    },
                    villageChange:function(){
                        this.hidden = this.frm.village;
                        console.log(this.frm)
                    },

                },
                created: async function(val) {
                    this.loadAddress(this.hidden)
                },
                watch: {
                    loadingHidden: function(val) {
                        @if (!old($field['name']))
                            if(!val){
                                $('.city_select').val('').trigger('change').select2('destroy').select2({
                                    theme: 'bootstap',
                                    width: '100%',
                                    placeholder: '-',
                                });
                                this.hidden = null;
                                this.districs = {};
                                this.communes = {};
                                this.villages = {};
                            }else{
                                this.loadAddress(val);
                            }
                        @endif
                    }
                },
                mounted() {
                    const vm = this;
                    $('.{{ $select2Class }}').select2({
                        theme: 'bootstrap',
                        width: '100%',
                        placeholder: '-',
                    }).on('select2:select', async function(e) {
                        const val = e.params.data.id;
                        let key = 'city';
                        let func = 'cityChange';

                        await $('.distric_select').select2('destroy').select2({
                            theme: 'bootstrap',
                            width: '100%',
                            placeholder: '-',
                        });

                        if(val.length == 8){
                            key = 'village';
                            func = 'villageChange';
                        }
                        if (val.length == 6) {
                            key = 'commune';
                            func = 'communeChange';
                        }
                        if (val.length == 4) {
                            key = 'distric';
                            func = 'districChange';
                        }

                        vm.frm[key] = val;
                        vm[func](e, true);
                        console.log(vm)
                    })


                    
                    @if ($errors->first($field['name']))
                        switch(this.hidden.length) {
                            case 0:
                                this.error.city = '{{ trans("validation.address_province/city") }}';
                                this.error.district = '{{ trans("validation.address_district/khan") }}';
                                this.error.commune = '{{ trans("validation.address_commune/sangkat") }}';
                                break;
                            case 2:
                                this.error.district = '{{ trans("validation.address_district/khan") }}';
                                this.error.commune = '{{ trans("validation.address_commune/sangkat") }}';
                                break;
                            case 4:
                                this.error.commune = '{{ trans("validation.address_commune/sangkat") }}';
                                break;
                            default:
                                break;
                        }
                    @endif
                },

            })
        </script>
    @endpush
@endif
{{-- </div> --}}
