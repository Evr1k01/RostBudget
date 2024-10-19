import {createVuetify} from "vuetify/dist/vuetify";
import 'vuetify/dist/vuetify.min.css'

import '@mdi/font/css/materialdesignicons.css'

import * as directives from 'vuetify/directives'

const vuetify = createVuetify({
    directives,
    icons: {
        iconfont: 'mdi',
    },
})

export default vuetify;
