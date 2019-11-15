<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">Example Component</div>

                    <div class="card-body">
                        <table>
                            <tr v-for="(item, index) in records" :index="index" :key="index">
                                <td><b>{{index}}</b></td>
                                <td> {{ item['0'] }} </td>
                                <td> {{ item['1'] }} </td>
                                <td><a href="#" v-on:click.prevent="deleteArray(index)">x</a></td>
                            </tr>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>



<script>
    export default {
        props: [
            'records'
        ],
        mounted() {
            this.records = this.records
            //console.log(this.$props.records)
        },
        methods: {
            deleteArray: function(index) {
                this.records.splice(index, 1)
                //this.$delete(this.records, index);
            },
            deleteObject: function(index) {
                this.$delete(this.records, index);
            },
        }
    }
</script>
