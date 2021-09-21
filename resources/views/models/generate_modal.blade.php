<div class="modal fade" id="model-generate-modal">
    <form id="model-generate-form" method="POST" data-template-action="{{route('models.generate', '%s')}}">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Select component to ignore</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-12">
                            <button class="btn btn-sm btn-primary mr-2" id="btnSelectAll"> Select All</button>
                            <button class="btn btn-sm btn-primary" id="btnDeselectAll"> Deselect All</button>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Migration Field -->
                        <div class="form-group col-sm-6">
                            <label class="checkbox-inline">
                                {!! Form::hidden('migration', '0', ['class' => 'ignore-reset']) !!}
                                {!! Form::checkbox('migration', '1', 1, ['data-column' => 'migration']) !!} Migration
                            </label>
                        </div>

                        <div class="form-group col-sm-6">
                            <label class="checkbox-inline">
                                {!! Form::hidden('model', '0', ['class' => 'ignore-reset']) !!}
                                {!! Form::checkbox('model', '1', 1, ['data-column' => 'model']) !!} Model
                            </label>
                        </div>

                        <div class="form-group col-sm-6">
                            <label class="checkbox-inline">
                                {!! Form::hidden('repository', '0', ['class' => 'ignore-reset']) !!}
                                {!! Form::checkbox('repository', '1', 1, ['data-column' => 'repository']) !!} Repository
                            </label>
                        </div>

                        <div class="form-group col-sm-6">
                            <label class="checkbox-inline">
                                {!! Form::hidden('factory', '0', ['class' => 'ignore-reset']) !!}
                                {!! Form::checkbox('factory', '1', 1, ['data-column' => 'factory']) !!} Factory
                            </label>
                        </div>

                        <div class="form-group col-sm-6">
                            <label class="checkbox-inline">
                                {!! Form::hidden('seeder', '0', ['class' => 'ignore-reset']) !!}
                                {!! Form::checkbox('seeder', '1', 1, ['data-column' => 'seeder']) !!} Seeder
                            </label>
                        </div>

                        <div class="form-group col-sm-6">
                            <label class="checkbox-inline">
                                {!! Form::hidden('requests', '0', ['class' => 'ignore-reset']) !!}
                                {!! Form::checkbox('requests', '1', 1, ['data-column' => 'requests']) !!} Requests
                            </label>
                        </div>

                        <div class="form-group col-sm-6">
                            <label class="checkbox-inline">
                                {!! Form::hidden('datatable', '0', ['class' => 'ignore-reset']) !!}
                                {!! Form::checkbox('datatable', '1', 1, ['data-column' => 'datatable']) !!} Datatable
                            </label>
                        </div>

                        <div class="form-group col-sm-6">
                            <label class="checkbox-inline">
                                {!! Form::hidden('controller', '0', ['class' => 'ignore-reset']) !!}
                                {!! Form::checkbox('controller', '1', 1, ['data-column' => 'controller']) !!} Controller
                            </label>
                        </div>

                        <div class="form-group col-sm-6">
                            <label class="checkbox-inline">
                                {!! Form::hidden('views', '0', ['class' => 'ignore-reset']) !!}
                                {!! Form::checkbox('views', '1', 1, ['data-column' => 'views']) !!} Views
                            </label>
                        </div>

                        <div class="form-group col-sm-6">
                            <label class="checkbox-inline">
                                {!! Form::hidden('routes', '0', ['class' => 'ignore-reset']) !!}
                                {!! Form::checkbox('routes', '1', 1, ['data-column' => 'routes']) !!} Routes
                            </label>
                        </div>

                        <div class="form-group col-sm-6">
                            <label class="checkbox-inline">
                                {!! Form::hidden('menu', '0', ['class' => 'ignore-reset']) !!}
                                {!! Form::checkbox('menu', '1', 1, ['data-column' => 'menu']) !!} Menu
                            </label>
                        </div>

                        <div class="form-group col-sm-6">
                            <label class="checkbox-inline">
                                {!! Form::hidden('lang', '0', ['class' => 'ignore-reset']) !!}
                                {!! Form::checkbox('lang', '1', 1, ['data-column' => 'lang']) !!} Lang
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Generate</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
    </form>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

@push('scripts')
    <script type="text/javascript">
        var modelGenerateModal = $('#model-generate-modal');
        var modelGenerateForm = $('#model-generate-modal #model-generate-form');
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            modelGenerateForm.on('submit', async (evt) => {
                evt.preventDefault();

                let options = {
                    mainText: "{{__("crud.are_you_sure")}}",
                    detailText: "{{__("vl-admin-tool-lang::models/model.are_you_sure_generate_model")}}",
                    cancel: "{{__("crud.cancel")}}",
                    agree: "{{__("crud.agree")}}",
                    icon: "warning",
                }

                let isConfirmed = await confirmBox(options);
                if (isConfirmed) {
                    sendFormAjax(modelGenerateForm, {
                        modal: modelGenerateModal,
                        onCompleted: function () {
                            setTimeout(() => {
                                window.location.reload();
                            }, 2000);
                        }
                    });
                }
            });

            $('#btnSelectAll').on('click', function (evt) {
               evt.preventDefault();
               $('#model-generate-form input[type=checkbox]').prop('checked', true);
            });

            $('#btnDeselectAll').on('click', function (evt) {
                evt.preventDefault();
                $('#model-generate-form input[type=checkbox]').prop('checked', false);
            });
        });
    </script>
@endpush
