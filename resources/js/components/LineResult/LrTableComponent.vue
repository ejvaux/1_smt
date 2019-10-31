<template>    
    <div class="card">
        <div class="card-body">    
    <div v-if="tabledata.pcbs"> 
        <div class="row">
            <div class="col-md">
                <h5 class='text-center font-weight-bold'>{{tabledata.linename}}</h5>
            </div>
        </div>
        <div class="row mb-1">
            <div class="table-responsive-lg w-100 text-nowrap">
                <table class="table" id="">
                    <thead>
                        <tr class="text-center">
                            <th class="border border-right" width='25%' colspan="2">PROCESS</th>
                            <th width='25%' colspan="2">BOTTOM</th>
                            <th width='25%' colspan="2">TOP</th>
                            <th width='25%'>ALL</th>
                        </tr>
                    </thead>
                    <tbody class='text-center'>
                        <tr>
                            <th width='25%' colspan="2">TYPE</th>
                            <th width='12.5%'>IN</th>
                            <th width='12.5%'>OUT</th>
                            <th width='12.5%'>IN</th>
                            <th width='12.5%'>OUT</th>
                            <th width='25%'>TOTAL</th>
                        </tr>
                        <tr>
                            <th width='12.5%' rowspan="2" style='vertical-align:middle;text-align:center;'>SHIFT</th>
                            <th width='12.5%'>DAY</th>
                            <td width='12.5%'>{{tabledata.dbi}}</td>
                            <td width='12.5%'>{{tabledata.dbo}}</td>
                            <td width='12.5%'>{{tabledata.dti}}</td>
                            <td width='12.5%'>{{tabledata.dto}}</td>
                            <td width='25%'>{{tabledata.dbi + tabledata.dbo + tabledata.dti + tabledata.dto}}</td>
                        </tr>
                        <tr>
                            <th width='12.5%'>NIGHT</th>
                            <td width='12.5%'>{{tabledata.nbi}}</td>
                            <td width='12.5%'>{{tabledata.nbo}}</td>
                            <td width='12.5%'>{{tabledata.nti}}</td>
                            <td width='12.5%'>{{tabledata.nto}}</td>
                            <td width='25%'>{{tabledata.nbi + tabledata.nbo + tabledata.nti + tabledata.nto}}</td>
                        </tr>
                        <tr>
                            <th width='25%' colspan="2">TOTAL</th>
                            <td width='12.5%'>{{tabledata.dbi + tabledata.nbi}}</td>
                            <td width='12.5%'>{{tabledata.dbo + tabledata.nbo}}</td>
                            <td width='12.5%'>{{tabledata.dti + tabledata.nti}}</td>
                            <td width='12.5%'>{{tabledata.dto + tabledata.nto}}</td>
                            <td width='25%'>{{tabledata.dbi + tabledata.dbo + tabledata.dti + tabledata.dto + tabledata.nbi + tabledata.nbo + tabledata.nti + tabledata.nto}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>        
    </div>
    <div v-else>
        <h3>NO DATA TO DISPLAY</h3>
    </div>
        </div>
    </div>
</template>
<script>
    export default {
        props   :   ['tabledata'],
        data(){
            return{
                data: this.tabledata
            }
        },
        methods: {
            
        },
    }
</script>
<style scoped>
    
</style>