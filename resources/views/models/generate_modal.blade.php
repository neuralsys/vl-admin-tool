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
                    <div class="row">
                        <!-- Timestamps Field -->
                        <div class="form-group col-sm-6">
                            <label class="checkbox-inline">
                                {!! Form::hidden('migration', '0', ['class' => 'ignore-reset']) !!}
                                {!! Form::checkbox('migration', '1', null, ['data-column' => 'migration']) !!} Migration
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
                        modal: modelGenerateModal
                    });
                }
            });
        });
    </script>
@endpush
