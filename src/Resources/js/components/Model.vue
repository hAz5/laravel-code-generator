<template>
    <v-row>
        <v-col cols="12" lg="6">
            <v-text-field v-model="model.name" label="model name" filled></v-text-field>
        </v-col>
        <v-col cols="12" lg="6">
            <v-text-field v-model="model.table" label="table name" filled></v-text-field>
        </v-col>
    </v-row>
</template>

<script>
export default {
    props: {
        model: {
            type: Object
        }
    }
}
</script>
