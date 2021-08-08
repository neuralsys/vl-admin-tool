<div class="col-12">
    <div class="row">
        <!-- First Field Id Field -->
        <div class="form-group col-sm-6" style="display: none">
            {!! Form::label(null, __('vl-admin-tool-lang::models/relation.fields.first_field_id').':') !!}
            {!! Form::number('first_field_id', $field_id, ['class' => 'form-control no-reset', 'data-column' => 'first_field_id']) !!}
        </div>

        <!-- Second Field Id Field -->
        <div class="form-group col-sm-6">
            {!! Form::label(null, __('vl-admin-tool-lang::models/relation.fields.second_field_id').':') !!}
            {!! Form::select('second_field_id', $fields, null, ['placeholder' => 'Choose Other Field', 'class' => 'form-control select2', 'data-column' => 'second_field_id', 'style' => "width: 100%"]) !!}
        </div>

        <!-- Type Field -->
        <div class="form-group col-sm-6">
            {!! Form::label(null, __('vl-admin-tool-lang::models/relation.fields.type').':') !!}
            {!! Form::select('type', $relationTypes, null, ['placeholder' => 'Choose Relation Type', 'class' => 'form-control select2', 'data-column' => 'type', 'style' => "width: 100%"]) !!}
        </div>
    </div>
</div>

<!--for m-n relation-->
<div class="mn-relation col-12">
    <div class="row">
        <!-- Table Name Field -->
        <div class="form-group col-12">
            {!! Form::label(null, __('vl-admin-tool-lang::models/relation.fields.table_name').':') !!}
            {!! Form::text('table_name', null, ['class' => 'form-control', 'data-column' => 'table_name']) !!}
        </div>

        <!-- Fk 1 Field -->
        <div class="form-group col-sm-6">
            {!! Form::label(null, __('vl-admin-tool-lang::models/relation.fields.fk_1').':') !!}
            {!! Form::text('fk_1', null, ['class' => 'form-control', 'data-column' => 'fk_1']) !!}
        </div>

        <!-- Fk 2 Field -->
        <div class="form-group col-sm-6">
            {!! Form::label(null, __('vl-admin-tool-lang::models/relation.fields.fk_2').':') !!}
            {!! Form::text('fk_2', null, ['class' => 'form-control', 'data-column' => 'fk_2']) !!}
        </div>
    </div>
</div>

@once
    @push('scripts')
        <script type="text/javascript">
            $(document).ready(function () {
                $('select[name="type"]').on('change', function (evt) {
                    let value = $(this).val();
                    if (value == "m-n") {
                        $('div.mn-relation').css('display', 'block');
                    } else {
                        $('div.mn-relation').css('display', 'none');
                    }
                });
            });
        </script>
    @endpush
@endonce
