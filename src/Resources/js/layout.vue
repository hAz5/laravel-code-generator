<template>
    <div>
        <v-app >
            <v-main :class="$store.state.themeDark ? '' : 'grey lighten-4'" v-if="logined">
                    <router-view :key="$route.fullPath" ref="child"/>
            </v-main>
            <v-snackbar :color="$store.state.ui.color" v-model="$store.state.ui.snack">
                <div v-html="$store.state.ui.message"></div>
                <v-btn dark text @click="$store.state.ui.snack = false">close</v-btn>
            </v-snackbar>
        </v-app>


    </div>


</template>
<script>


export default {
    props: {
        data: Object,
    },
    data() {
        return {
            logined: true,
            loading: false,
            themeDark: false,
            navigation: false,
            navigationListItem: [
                {title: 'users', icon: 'mdi-account-multiple-outline', route: '/users'},
                {title: 'roles', icon: 'mdi-account-cog-outline', route: '/roles'},
                {title: 'designers', icon: 'mdi-hanger', route: '/designers'},
                {title: 'designer', icon: 'mdi-hanger', route: '/designers/1'},
                {title: 'invoices', icon: 'mdi-currency-usd', route: '/invoices'},
            ]
        }
    },

    mounted() {
      console.log('layout loaded');
    },

    methods: {
        themeDarkManager() {
            this.themeDark = !this.themeDark
            this.$vuetify.theme.dark = !this.$vuetify.theme.dark
            this.$store.commit('setTheme', this.themeDark)
        }
    }
}
</script>
<style>
*:focus {
    outline: none !important;
}
</style>
