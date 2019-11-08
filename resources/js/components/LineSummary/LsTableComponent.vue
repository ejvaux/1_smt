<template>    
    <div class="card">
        <div class="card-body">    
    <!-- <div v-if="tabledata.pcbs"> --> 
        <div class="row mb-1">
            <div class="table-responsive w-100 text-nowrap">
                <table class="table table-hover" id="summary_table">
                    <thead>
                        <tr class="text-center">
                            <th>DATE</th>
                            <th :key='line.id' v-for="line in lines">
                                {{line.name}}
                            </th>
                        </tr>
                    </thead>
                    <tbody class='text-center'>
                        <tr v-if="loading">
                            <td :colspan="lines.length + 1">P R O C E S S I N G . . . P L E A S E . . W A I T . . . <img :src="image_src"> </td>
                        </tr>
                        <tr :key='key' v-for="(data,key) in tabledata">
                            <th>{{data.date}}</th>
                            <td :key='val.id' v-for="(val) in data.total">
                                {{val}}
                            </td>
                        </tr>                        
                    </tbody>
                </table>
            </div>
        </div>        
    <!-- </div>
    <div v-else>
        <h3>NO DATA TO DISPLAY</h3>
    </div> -->
        </div>
    </div>
</template>
<script>
    export default {
        props   :   ['tabledata','lines','loading'],
        data(){
            return{
                data: [],
                image_src: 'http://172.16.1.13:8000/1_smt/public/images/103.gif'
            }
        },
        methods: {
            
        },
    }
</script>
<style scoped>
    
</style>