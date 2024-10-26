import {createStore} from "vuex";
import loggedUser from "./loggedUser";
import purchase from "./purchase";
import currency from "./currency";

const store = createStore({
    modules: {
        loggedUser,
        purchase,
        currency
    }
})

export default store;
