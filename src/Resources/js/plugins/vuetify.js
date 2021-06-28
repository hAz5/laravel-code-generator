import Vue from 'vue'
import Vuetify from 'vuetify/lib'

Vue.use(Vuetify)

const opts = {
    rtl: false,
    theme: {
        themes: {
            light: {
                primary: '#3F51B5',
                secondary: '#FFCDD2',
                accent: '#3F51B5'
            }
        }
    }
}

export default new Vuetify(opts)
