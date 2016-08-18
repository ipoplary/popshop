@if(! isset($pictureTypeService))
    @inject('pictureTypeService', 'App\Services\pictureTypeService')
@endif

<div class="modal fade bs-example-modal-lg" id="selectModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">

        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">选择图片</h4>
                @foreach($pictureTypeService->pictureType() as $pictureType)
                    <li v-on:click="getPicutures({{ $pictureType['id'] }}, 0)" v-bind:class="[type == '{{ $pictureType['id'] }}'? 'active':'']">
                        <a href="javaScript:;">{{ $pictureType['name'] }}</a>
                    </li>
                @endforeach
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-success" v-on:click="confirm">确定</button>
                <button type="button" class="btn btn-default" v-on:click="hide">取消</button>
            </div>
        </div>
    </div>
</div>

<script>
    var selectVm = new Vue({
        el: "#selectModal",
        data: {
            pictureList: [],
        },
        ready: function() {

        },
        methods: {
            show: function() {

                $('#selectModal').modal('show');
                return;
            },
            hide: function() {
                $('#selectModal').modal('hide');
                return;
            },
        }
    });
</script>