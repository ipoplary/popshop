@extends('admin.layout')

@section('title', 'Product')

@section('app', 'product')

@section('content')

    <div class="row" id="app">
        <div class="col-md-12">
            <form class="form-horizontal">
                <fieldset>
                    <div>
                        <legend class="">添加商品</legend>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2">Text input</label>
                        <div class="controls col-sm-3">
                            <input type="text" placeholder="placeholder" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2" for="input01">Text input</label>
                        <div class="controls col-sm-3">
                            <input type="text" placeholder="placeholder" class="form-control">

                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Select - Basic</label>
                        <div class="controls">
                            <select class="input-xlarge">
                                <option>Enter</option>
                                <option>Your</option>
                                <option>Options</option>
                                <option>Here!</option>
                            </select>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="input01">Text input</label>
                        <div class="controls">
                            <input type="text" placeholder="placeholder" class="input-xlarge">
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="input01">Text input</label>
                        <div class="controls">
                            <input type="text" placeholder="placeholder" class="input-xlarge">
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="input01">Text input</label>
                        <div class="controls">
                            <input type="text" placeholder="placeholder" class="input-xlarge">
                            <p class="help-block">Supporting help text</p>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="input01">Text input</label>
                        <div class="controls">
                            <input type="text" placeholder="placeholder" class="input-xlarge">
                            <p class="help-block">Supporting help text</p>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Textarea</label>
                        <div class="controls">
                            <div class="textarea">
                                <textarea type="" class=""> </textarea>
                            </div>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="input01">Text input</label>
                        <div class="controls">
                            <input type="text" placeholder="placeholder" class="input-xlarge">
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="input01">Text input</label>
                        <div class="controls">
                            <input type="text" placeholder="placeholder" class="input-xlarge">
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>

@endsection

@section('script')
<script>
</script>
@endsection