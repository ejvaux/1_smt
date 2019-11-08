<template>
    <div>
        <div class="row form-group">                                
            <div class="col-md-8">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text" id="">FROM :</div>
                    </div>
                    <input type="date" id="from_date" name="from_date" class="form-control" v-model="from_date">
                    <div class="input-group-prepend">
                        <div class="input-group-text" id="">TO :</div>
                    </div>
                    <input type="date" id="to_date" name="to_date" class="form-control" v-model="to_date">
                    <button type="button" class='' v-on:click="getLS">GO</button>
                </div>
            </div>
            <div class="col-md-2">
                <button type="button" id="" class="form-control" v-on:click="exportLS">EXPORT</button>
            </div>
        </div>
        <div class="row">
            <div class="col-md text-center">
                <div id="lr_div" style='transition:2s'>
                    <ls-table-component :lines="lines" :tabledata="data" :loading='load'></ls-table-component>
                </div>                               
            </div>
        </div>
    </div>
</template>
<script>
    /* import LrTableComponent from './LrTableComponent.vue'; */
    export default {
        props   :   ['datenow','lines'],
        data: function(){
            return  {
                from_date: this.datenow,
                to_date: this.datenow,
                data: [],
                count: 0,
                date_arr: [],
                load: 0
            }
        },
        methods: {            
            getLS: function(){
                var _this = this;
                /* var date_array =[]; */
                var from = moment(this.from_date);
                var to = moment(this.to_date);
                while (from <= to) {
                    _this.date_arr.push(moment(from).format('YYYY-MM-DD'));
                    from = moment(from).add(1, 'days');
                }
                /* alert(date_array); */
                this.data = [];
                _this.load = 1;
                _this.getRow();
                /* $.ajax({
                    url:    'gs',
                    data:{
                        date:  date_array
                    },
                    global: false,
                    success: function(data){
                        _this.data.push(data);
                    }
                }); */
                /* $.each(date_array,function(key,val){                     
                     _this.getRow(val);
                }); */
            },
            getRow: function(){
                var _this = this;
                var len = _this.date_arr.length;
                if(_this.count != len){
                    $.ajax({
                    url:    'gs',
                    data:{
                        date:  _this.date_arr[_this.count]
                    },
                    global: false,
                    success: function(data){
                        _this.data.unshift(data);
                        _this.count++;
                        _this.getRow();
                    }
                });
                }

                if(_this.count == len){
                    _this.load = 0;
                }

                /* $.ajax({
                    url:    'gs',
                    data:{
                        date:  val
                    },
                    global: false,
                    success: function(data){
                        _this.data.push(data);
                    }
                }); */
                /* $.get('gs',
                {
                    date:  val
                },
                function(data){
                    _this.data.push(data);
                }); */
            },
            exportLS: function(){
                alert('Export');
            }
        },
    }
</script>
<style scoped>
    
</style>