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
                            <th width='20%' colspan="2" class="border-right">PROCESS</th>
                            <th width='20%' colspan="2" class="border-right">BOTTOM</th>
                            <th width='20%' colspan="2" class="border-right">TOP</th>
                            <th width='20%' colspan="2" class="border-right">DIP</th>
                            <th width='20%'>ALL</th>
                        </tr>
                    </thead>
                    <tbody class='text-center'>
                        <tr>
                            <th width='20%' colspan="2" class="border-right">TYPE</th>
                            <th width='10%' class="border-right">IN</th>
                            <th width='10%' class="border-right">OUT</th>
                            <th width='10%' class="border-right">IN</th>
                            <th width='10%' class="border-right">OUT</th>
                            <th width='10%' class="border-right">IN</th>
                            <th width='10%' class="border-right">OUT</th>
                            <th width='20%'>TOTAL</th>
                        </tr>
                        <tr>
                            <th width='10%' rowspan="2" style='vertical-align:middle;text-align:center;' class="border-right">SHIFT</th>
                            <th width='10%' class="border-right">DAY</th>
                            <td width='10%' class="border-right">{{tabledata.dbi}}</td>
                            <td width='10%' class="border-right">{{tabledata.dbo}}</td>
                            <td width='10%' class="border-right">{{tabledata.dti}}</td>
                            <td width='10%' class="border-right">{{tabledata.dto}}</td>
                            <td width='10%' class="border-right">{{tabledata.ddi}}</td>
                            <td width='10%' class="border-right">{{tabledata.ddo}}</td>
                            <td width='20%'>{{dayTotal}}</td>
                        </tr>
                        <tr>
                            <th width='10%' class="border-right">NIGHT</th>
                            <td width='10%' class="border-right">{{tabledata.nbi}}</td>
                            <td width='10%' class="border-right">{{tabledata.nbo}}</td>
                            <td width='10%' class="border-right">{{tabledata.nti}}</td>
                            <td width='10%' class="border-right">{{tabledata.nto}}</td>
                            <td width='10%' class="border-right">{{tabledata.ndi}}</td>
                            <td width='10%' class="border-right">{{tabledata.ndo}}</td>
                            <td width='20%'>{{nightTotal}}</td>
                        </tr>
                        <tr>
                            <th width='20%' colspan="2" class="border-right">TOTAL</th>
                            <td width='10%' class="border-right">{{botInTotal}}</td>
                            <td width='10%' class="border-right">{{botOutTotal}}</td>
                            <td width='10%' class="border-right">{{topInTotal}}</td>
                            <td width='10%' class="border-right">{{topOutTotal}}</td>
                            <td width='10%' class="border-right">{{dipInTotal}}</td>
                            <td width='10%' class="border-right">{{dipOutTotal}}</td>
                            <td width='20%'><u class="font-weight-bold">{{overallTotal}}</u></td>
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
        computed: {
            botInTotal: function(){
                return  this.tabledata.dbi + this.tabledata.nbi
            },
            botOutTotal: function(){
                return  this.tabledata.dbo + this.tabledata.nbo
            },
            topInTotal: function(){
                return  this.tabledata.dti + this.tabledata.nti
            },
            topOutTotal: function(){
                return  this.tabledata.dto + this.tabledata.nto
            },
            dipInTotal: function(){
                return  this.tabledata.ddi + this.tabledata.ndi
            },
            dipOutTotal: function(){
                return  this.tabledata.ddo + this.tabledata.ndo
            },
            dayTotal: function(){
                return  this.tabledata.dbi + 
                        this.tabledata.dbo + 
                        this.tabledata.dti + 
                        this.tabledata.dto + 
                        this.tabledata.ddi + 
                        this.tabledata.ddo;
            },
            nightTotal: function(){
                return  this.tabledata.nbi + 
                        this.tabledata.nbo + 
                        this.tabledata.nti + 
                        this.tabledata.nto + 
                        this.tabledata.ndi + 
                        this.tabledata.ndo;
            },
            overallTotal: function(){
                return  this.tabledata.dbi + 
                        this.tabledata.dbo + 
                        this.tabledata.dti + 
                        this.tabledata.dto + 
                        this.tabledata.nbi + 
                        this.tabledata.nbo + 
                        this.tabledata.nti + 
                        this.tabledata.nto + 
                        this.tabledata.ddi + 
                        this.tabledata.ndi + 
                        this.tabledata.ddo + 
                        this.tabledata.ndo
            }
        },
        methods: {
            
        },
    }
</script>
<style scoped>
    
</style>