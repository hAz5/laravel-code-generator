<template>
    <div>
        <v-navigation-drawer color="transparent" floating app right width="350">
            <div class="m-3 mr-0 rounded-lg overflow-hidden primary darken-2" style="height: calc(100vh - 24px)">
                <v-sheet class="p-10" color="primary darken-3" height="100" dark>
                    <v-btn color="red" dark @click="() => showDialog()"  block x-large>
                        Generate
                        <v-icon right dark>
                            mdi-bomb
                        </v-icon>
                    </v-btn>
                </v-sheet>
                <v-list dark nav color="primary darken-2" class="px-4">
                    <v-list-item class="pr-0">
                        <v-list-item-content>
                        </v-list-item-content>
                    </v-list-item>
                </v-list>
            </div>
        </v-navigation-drawer>



        <div class="m-5 mt-5">

            <v-row class="text-center"> <h2>Generator</h2></v-row>
            <model :model="model"/>

            <v-btn class="mb-5" @click="addColumn"> add column</v-btn>
            <v-row v-for="(item, index) in columns" :key="index">
                {{ index + 1 }} -
                <column-property :item="item" @delete="() => removeColumn(index)"/>
            </v-row>


            <v-dialog
                v-model="dialog"
                max-width="290">
                <v-card>
                    <v-card-title class="text-h5">
                        Alert
                    </v-card-title>
                    <v-card-text>
                        are you sure?
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn text @click="dialog = false">no</v-btn>
                        <v-btn dark color="success" @click="() => save()">yes</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>

        </div>
    </div>
</template>

<script>
import Model from '../components/Model'
import ColumnProperty from '../components/ColumnProperty'
import {posting} from "../helpers/network";

export default {
    components: {Model, ColumnProperty},
    data() {
        return {
            model: {
                name: '',
                table: ''
            },
            dialog: false,
            columns: []
        }
    },

    methods: {
        showDialog() {
            this.dialog = true;
        },
        addColumn() {
            this.columns.push({fieldName: '', type: '', defaultValue: '', index: false, nullable: true});
        },
        removeColumn(index) {
            this.$delete(this.columns, index)
        },
        save() {
            this.dialog = false;

            posting('/cg/generate', {model: this.model, columns: this.columns}
            ).then(response => {
                this.$store.commit('message', 'saved')
            }).catch(error => {
                console.log(error)
                this.$store.commit('error', 'error message');
            }).finally(() => {

            })
        },
    },
}
</script>
