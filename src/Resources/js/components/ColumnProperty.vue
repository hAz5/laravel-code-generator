<template>
    <v-row>
        <v-col cols="12" lg="3">
            <v-text-field v-model="item.fieldName" label="field name" filled></v-text-field>

        </v-col>
        <v-col cols="12" lg="2">
            <v-select v-model="item.type"  :items="type" label="type" filled/>
        </v-col>
        <v-col cols="12" lg="2">
            <v-text-field v-model="item.defaultValue" label="default value" filled></v-text-field>
        </v-col>

        <v-col cols="12" lg="3" class="flex">
            <v-checkbox label="nullable" v-model="item.nullable" class="mr-2"/>
            <v-checkbox label="index" v-model="item.index" />
        </v-col>

        <v-col cols="12" lg="2">
            <v-btn icon color="red" @click="$emit('delete')">
                <v-icon>mdi-delete</v-icon>
            </v-btn>
        </v-col>

    </v-row>
</template>

<script>
export default {
    props: {
        item:{
            type: Object,
        }
    },
    data() {
        return {
            type: [
                'string',
                'float',
                'integer',
                'boolean',
                'date',
                'foreign',
            ]
        }
    }
}
</script>
