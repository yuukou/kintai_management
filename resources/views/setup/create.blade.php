@extends('layouts.default')
@section('content')
    <div class="btns">
        <div class="txtCenter hereArea">
            <p class="errorMsg">
                <?php if (!empty($import_data['error']['here'])) : ?>
                    <?php echo $import_data['error']['here']; ?>
                    <?php endif; ?>
            </p>
        </div>
        <div class="btn_wrapper">
            {{ Form::button('🌞', ['class' => 'btn js_set_up_btn on_btn', 'id' => 'info1']) }}
            <p class="arrive_description">出社</p>
        </div>
        <div class="txtCenter hereArea">
            <p class="errorMsg">
                <?php if (!empty($import_data['error']['here'])) : ?>
                    <?php echo $import_data['error']['here']; ?>
                    <?php endif; ?>
            </p>
        </div>
        <div class="btn_wrapper">
            {{ Form::button('🌚', ['class' => 'btn js_set_up_btn on_btn', 'id' => 'info2']) }}
            <p class="leave_description">退社</p>
        </div>
    </div>
@endsection