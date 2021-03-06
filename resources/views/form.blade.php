<style>
    [v-cloak] {
        display: none;
    }

    .diy-main {
        background: #f7f7f7;
        border-radius: .25rem;
        padding: 5px 20px;
        display: flex;
        justify-content: space-around;
        max-height: 600px;
        min-width: 650px;
    }

    .diy-card {
        background: #fff;
        border-radius: .25rem;
        padding: 15px;
        margin: 5px;
        overflow: auto;
    }

    .add-btn-div {
        display: flex;
        justify-content: end;
        padding-top: 20px;
    }

    .type-item {
        width: 100%;
        border: 1px solid #f1f1f1;
        padding: 5px;
        border-radius: .25rem;
        text-align: center;
        margin: 10px 0;
        cursor: pointer;
    }

    .type-item:hover {
        border-color: {{ $theme_color }};
    }

    .type-item-active {
        background: {{ Admin::color()->alpha($theme_color, 0.3) }};
        border-color: transparent;
    }

    .card-label {
        margin-bottom: 5px;
        border-bottom: 1px solid #f7f7f7;
        width: 100%;
        padding-bottom: 5px;
    }

    .props-item {
        padding: 3px 0;
        display: flex;
        align-items: center;
    }

    .props-label {
        min-width: 60px;
    }

    .option-area {
        background: #f7f7f7;
        padding: 5px;
        overflow: auto;
        border-radius: .25rem;
    }

    .option-area > div:not(:last-child) {
        margin-bottom: 3px;
    }

    .option-action {
        font-size: 20px;
        padding: 0 10px;
        font-weight: bold;
        cursor: pointer;
        border: 1px solid #dbe3e6;
        border-radius: 0.25rem;
        background: #fff;
    }

    .option-action:hover {
        background: #f7f7f7;
    }

    .cursor-pointer {
        cursor: pointer;
    }

    .preview-item {
        margin-top: 10px;
    }

    .move-item {
        padding: 0 5px;
        cursor: pointer;
    }

    .hover-line:hover {
        border-bottom: 1px solid;
    }
</style>

<div class="{{$viewClass['form-group']}}">

    <label class="{{$viewClass['label']}} control-label">{{$label}}</label>

    <div class="{{$viewClass['field']}}">

        @include('admin::form.error')

        <div {!! $attributes !!} style="width: 100%; height: 100%; overflow: auto" v-cloak>
            <div class="diy-main">
                {{--??????????????????--}}
                <div class="diy-card col-4">
                    <div class="form-group">
                        <label class="card-label">????????????</label>
                        <div class="type-item"
                             v-for="(item, index) in component_type"
                             :key="index"
                             :class="{'type-item-active': current_type.type == item.type}"
                             v-on:click="selectType(item)">
                            @{{ item.name }}
                        </div>
                    </div>
                </div>

                {{--????????????--}}
                <div class="diy-card col-4 d-flex flex-column">
                    <label class="card-label">??????</label>
                    <div class="d-flex justify-content-between flex-column h-auto flex-grow-1">
                        <div>
                            <div v-if="current_type">
                                <div class="props-item">
                                    <div class="props-label">??????</div>
                                    <div class="">@{{ current_type.name }}</div>
                                </div>
                                <div class="props-item">
                                    <div class="props-label">??????</div>
                                    <div class="">
                                        <input type="text"
                                               class="form-control form-control-sm"
                                               v-model="current_type.label"
                                               placeholder="???????????????">
                                    </div>
                                </div>
                                <div class="props-item">
                                    <div class="props-label">??????</div>
                                    <div class="">
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio"
                                                   id="required_yes"
                                                   name="need_required"
                                                   value="1"
                                                   v-model="current_type.required"
                                                   class="custom-control-input">
                                            <label class="custom-control-label" for="required_yes">
                                                ???
                                            </label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio"
                                                   id="required_no"
                                                   name="need_required"
                                                   value="0"
                                                   v-model="current_type.required"
                                                   class="custom-control-input">
                                            <label class="custom-control-label" for="required_no">
                                                ???
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="props-item">
                                    <div class="props-label">?????????</div>
                                    <div class="">
                                        <input type="text"
                                               class="form-control form-control-sm"
                                               v-model="current_type.default_value"
                                               :placeholder="current_type.type == 'checkbox' ? '?????????,(????????????)??????' : '??????????????????'">
                                    </div>
                                </div>
                                {{--???????????????--}}
                                <div class="props-item" v-for="(item, index) in current_type.props_items" :key="index">
                                    <div class="props-label">@{{ item.label }}</div>
                                    <div class="">
                                        <input type="text"
                                               class="form-control form-control-sm"
                                               v-model="current_type[item.bind]"
                                               :placeholder="`?????????${item.label}`">
                                    </div>
                                </div>
                                {{--??????--}}
                                <div class="props-item" v-if="current_type.options">
                                    <div class="props-label">@{{ current_type.options.label }}</div>
                                    <div class="option-area">
                                        <div class="d-flex"
                                             v-for="(item, index) in current_type.options.values"
                                             :key="index">
                                            <input type="text"
                                                   class="form-control form-control-sm"
                                                   v-model="current_type.options.values[index]">
                                            <div class="option-action"
                                                 v-if="index + 1 == current_type.options.values.length"
                                                 v-on:click="addOptions">+
                                            </div>
                                            <div class="option-action"
                                                 v-if="current_type.options.values.length > 1"
                                                 v-on:click="subOptions(index)">-
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="add-btn-div">
                            <button type="button" class="btn btn-primary" v-on:click="addItem">??????</button>
                        </div>
                    </div>
                </div>

                <div class="diy-card col-4">
                    <label class="card-label">??????</label>
                    <div>
                        <div v-for="(item, index) in contents" :key="index">
                            {{--???????????????html--}}
                            {!! $preview_html !!}

                            {{--input--}}
                            <div class="preview-item" v-if="item.type == 'input'" :class="'animate-item-' + index">
                                <label class="d-flex justify-content-between">
                                    <div>
                                        <span class="text-danger" v-if="item.required == 1">* </span>
                                        @{{ item.label }}
                                    </div>
                                    <div>
                                        <span class="move-item hover-line"
                                              v-if="index != 0"
                                              v-on:click="previewItemGoUp(index)">
                                            <i class="feather icon-arrow-up"></i>
                                        </span>
                                        <span class="move-item hover-line"
                                              v-if="index != contents.length - 1"
                                              v-on:click="previewItemGoDown(index)">
                                            <i class="feather icon-arrow-down"></i>
                                        </span>
                                        <span class="text-danger cursor-pointer hover-line"
                                              v-on:click="subPreviewItem(index)">
                                            ??????
                                        </span>
                                    </div>
                                </label>
                                <div class="">
                                    <input type="text"
                                           class="form-control form-control-sm"
                                           :value="item.default_value"
                                           :placeholder="`?????????${item.label}`">
                                </div>
                            </div>

                            {{--textarea--}}
                            <div class="preview-item" v-if="item.type == 'textarea'" :class="'animate-item-' + index">
                                <label class="d-flex justify-content-between">
                                    <div>
                                        <span class="text-danger" v-if="item.required == 1">* </span>
                                        @{{ item.label }}
                                    </div>
                                    <div>
                                        <span class="move-item hover-line"
                                              v-if="index != 0"
                                              v-on:click="previewItemGoUp(index)">
                                            <i class="feather icon-arrow-up"></i>
                                        </span>
                                        <span class="move-item hover-line"
                                              v-if="index != contents.length - 1"
                                              v-on:click="previewItemGoDown(index)">
                                            <i class="feather icon-arrow-down"></i>
                                        </span>
                                        <span class="text-danger cursor-pointer hover-line"
                                              v-on:click="subPreviewItem(index)">
                                            ??????
                                        </span>
                                    </div>
                                </label>
                                <div class="">
                                    <textarea class="form-control"
                                              :rows="item.rows"
                                              :value="item.default_value"></textarea>
                                </div>
                            </div>

                            {{--radio--}}
                            <div class="preview-item" v-if="item.type == 'radio'" :class="'animate-item-' + index">
                                <label class="d-flex justify-content-between">
                                    <div>
                                        <span class="text-danger" v-if="item.required == 1">* </span>
                                        @{{ item.label }}
                                    </div>
                                    <div>
                                        <span class="move-item hover-line"
                                              v-if="index != 0"
                                              v-on:click="previewItemGoUp(index)">
                                            <i class="feather icon-arrow-up"></i>
                                        </span>
                                        <span class="move-item hover-line"
                                              v-if="index != contents.length - 1"
                                              v-on:click="previewItemGoDown(index)">
                                            <i class="feather icon-arrow-down"></i>
                                        </span>
                                        <span class="text-danger cursor-pointer hover-line"
                                              v-on:click="subPreviewItem(index)">
                                            ??????
                                        </span>
                                    </div>
                                </label>
                                <div class="">
                                    <div class="custom-control custom-radio custom-control-inline"
                                         v-for="(opt, opt_key) in item.options.values"
                                         :key="opt_key">
                                        <input type="radio"
                                               :id="'radio_item_' + index + opt_key"
                                               :name="'radio_' + index"
                                               :checked="opt == item.default_value"
                                               class="custom-control-input">
                                        <label class="custom-control-label" :for="'radio_item_' + index + opt_key">
                                            @{{ opt }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            {{--checkbox--}}
                            <div class="preview-item" v-if="item.type == 'checkbox'" :class="'animate-item-' + index">
                                <label class="d-flex justify-content-between">
                                    <div>
                                        <span class="text-danger" v-if="item.required == 1">* </span>
                                        @{{ item.label }}
                                    </div>
                                    <div>
                                        <span class="move-item hover-line"
                                              v-if="index != 0"
                                              v-on:click="previewItemGoUp(index)">
                                            <i class="feather icon-arrow-up"></i>
                                        </span>
                                        <span class="move-item hover-line"
                                              v-if="index != contents.length - 1"
                                              v-on:click="previewItemGoDown(index)">
                                            <i class="feather icon-arrow-down"></i>
                                        </span>
                                        <span class="text-danger cursor-pointer hover-line"
                                              v-on:click="subPreviewItem(index)">
                                            ??????
                                        </span>
                                    </div>
                                </label>
                                <div class="">
                                    <div class="custom-control custom-checkbox custom-control-inline"
                                         v-for="(opt, opt_key) in item.options.values"
                                         :key="opt_key">
                                        <input type="checkbox"
                                               class="custom-control-input"
                                               :checked="item.default_value && item.default_value.split(',').indexOf(opt) > -1"
                                               :id="'checkbox_item_' + index + opt_key">
                                        <label class="custom-control-label" :for="'checkbox_item_' + index + opt_key">
                                            @{{ opt }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            {{--select--}}
                            <div class="preview-item" v-if="item.type == 'select'" :class="'animate-item-' + index">
                                <label class="d-flex justify-content-between">
                                    <div>
                                        <span class="text-danger" v-if="item.required == 1">* </span>
                                        @{{ item.label }}
                                    </div>
                                    <div>
                                        <span class="move-item hover-line"
                                              v-if="index != 0"
                                              v-on:click="previewItemGoUp(index)">
                                            <i class="feather icon-arrow-up"></i>
                                        </span>
                                        <span class="move-item hover-line"
                                              v-if="index != contents.length - 1"
                                              v-on:click="previewItemGoDown(index)">
                                            <i class="feather icon-arrow-down"></i>
                                        </span>
                                        <span class="text-danger cursor-pointer hover-line"
                                              v-on:click="subPreviewItem(index)">
                                            ??????
                                        </span>
                                    </div>
                                </label>
                                <div class="">
                                    <select class="form-control form-control-sm">
                                        <option
                                            v-for="(opt, opt_key) in item.options.values"
                                            :selected="opt == item.default_value"
                                            :key="opt_key">
                                            @{{ opt }}
                                        </option>
                                    </select>
                                </div>
                            </div>

                            {{--upload--}}
                            <div class="preview-item"
                                 v-if="item.type == 'upload-image' || item.type == 'upload-vedio'"
                                 :class="'animate-item-' + index">
                                <label class="d-flex justify-content-between">
                                    <div>
                                        <span class="text-danger" v-if="item.required == 1">* </span>
                                        @{{ item.label }}
                                    </div>
                                    <div>
                                        <span class="move-item hover-line"
                                              v-if="index != 0"
                                              v-on:click="previewItemGoUp(index)">
                                            <i class="feather icon-arrow-up"></i>
                                        </span>
                                        <span class="move-item hover-line"
                                              v-if="index != contents.length - 1"
                                              v-on:click="previewItemGoDown(index)">
                                            <i class="feather icon-arrow-down"></i>
                                        </span>
                                        <span class="text-danger cursor-pointer hover-line"
                                              v-on:click="subPreviewItem(index)">
                                            ??????
                                        </span>
                                    </div>
                                </label>
                                <div class="">
                                    <button type="button" class="btn btn-default btn-sm" v-on:click="previewTips">
                                        @{{ item.name }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <input type="hidden" name="{{$name}}" value="{{ old($column, $value) }}" v-model="submit_value"/>
        </div>

        @include('admin::form.help-block')

    </div>
</div>

<script init="{!! $selector !!}">
    new Vue({
        el: `#${id}`,
        data: {
            component_type: {!! admin_javascript_json($component_type) !!},
            contents: [],
            current_type: '',
            submit_value: '',
        },
        mounted() {
            let edit_data = '{!! old($column, $value) !!}'

            if (edit_data) {
                this.contents = JSON.parse(edit_data)
            }
        },
        methods: {
            // ????????????
            addItem() {
                let data = this.current_type
                if (!data) {
                    return Dcat.error('????????????????????????')
                }

                if (!data.label) {
                    return Dcat.error('???????????????')
                }

                if (data.options) {
                    if (data.options.values.length < 2) {
                        return Dcat.error(`?????????????????????${data.options.label}`)
                    }

                    let nullValue = 0
                    data.options.values.forEach((item) => {
                        if (item == '') {
                            nullValue++
                        }
                    })

                    if (nullValue > 0) {
                        return Dcat.error(data.options.label + '????????????')
                    }
                }

                if (data.validate_handler) {
                    let message = data.validate_handler(data)

                    if (message) {
                        return Dcat.error(message)
                    }
                }

                this.contents.push(this.deepCopy(data))
                this.current_type = ''
                this.submitValueHandler()
            },
            // ??????????????????
            selectType(item) {
                this.current_type = this.deepCopy(item)
            },
            // ????????????
            addOptions() {
                this.current_type.options.values.push('')
            },
            // ????????????
            subOptions(index) {
                this.current_type.options.values.splice(index, 1)
            },
            // ?????????
            deepCopy(value) {
                return JSON.parse(JSON.stringify(value))
            },
            // ??????????????????
            previewTips() {
                Dcat.warning('????????????, ???????????????')
            },
            // ???????????????
            subPreviewItem(index) {
                this.contents.splice(index, 1)
                this.submitValueHandler()
            },
            // ???????????????
            previewItemGoUp(index) {
                $('.animate-item-' + index).fadeOut('fast')
                $('.animate-item-' + (index - 1)).fadeOut('fast')

                setTimeout(() => {
                    let temp = ''
                    temp = this.contents[index]
                    this.contents[index] = this.contents[index - 1]
                    this.contents[index - 1] = temp
                    this.$forceUpdate()
                    this.submitValueHandler()

                    $('.animate-item-' + index).fadeIn('fast')
                    $('.animate-item-' + (index - 1)).fadeIn('fast')
                }, 150)
            },
            // ???????????????
            previewItemGoDown(index) {
                $('.animate-item-' + index).fadeOut('fast')
                $('.animate-item-' + (index + 1)).fadeOut('fast')

                setTimeout(() => {
                    let temp = ''
                    temp = this.contents[index]
                    this.contents[index] = this.contents[index + 1]
                    this.contents[index + 1] = temp
                    this.$forceUpdate()
                    this.submitValueHandler()

                    $('.animate-item-' + index).fadeIn('fast')
                    $('.animate-item-' + (index + 1)).fadeIn('fast')
                }, 150)
            },
            submitValueHandler() {
                this.submit_value = JSON.stringify(this.contents)
            }
        }
    })
</script>
