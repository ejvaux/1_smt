<template>
    <div>
        <div class="row form-group">                                
            <div class="col-md-8">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text" id="">Date :</div>
                    </div>
                    <input type="date" id="date" name="date" class="form-control" v-model="date">                
                    <div class="input-group-prepend">
                        <div class="input-group-text" id="">Line :</div>
                    </div>
                    <select class="form-control" name="line" id="line" v-model="line">
                        <option :key="line.id" v-for="line in lines" :value="line.id">
                            {{line.name}}
                        </option>                                           
                    </select>
                    <button type="button" class='' v-on:click="getLR">GO</button>
                </div>
            </div>
            <div class="col-md-2">
                <button type="button" id="export-lr-btn" class="form-control">EXPORT</button>
            </div>
        </div>
        <div class="row">
            <div class="col-md text-center">
                <div id="lr_div" style='transition:2s'>
                    <lr-table-component :tabledata='data'></lr-table-component>
                </div>                               
            </div>
        </div>
    </div>
</template>
<script>
    import LrTableComponent from './LrTableComponent.vue';
    export default {
        props   :   ['datenow','lines','imgsrc'],
        data: function(){
            return  {
                date: this.datenow,
                line: 1,
                data: {},
                isloading: 0
            }
        },
        methods: {
            getLR: function(){
                $("#wait").css("display", "block");
                window.axios.get('rt',{
                    params:{
                        date:  this.date,
                        line:  this.line
                    }                    
                }).then(({ data }) => {
                    /* alert(JSON.stringify(data)); */
                    this.data = data
                    $("#wait").css("display", "none");
                });
            }
        },
    }
</script>
<style scoped>
    
</style>