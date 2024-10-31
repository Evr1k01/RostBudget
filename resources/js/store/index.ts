import {createStore} from "vuex";
import loggedUser from "./loggedUser";
import purchase from "./purchase";
import currency from "./currency";
import category from "./category";
import system from "./system";

const store = createStore({
    modules: {
        loggedUser,
        purchase,
        currency,
        category,
        system
    }
})

export default store;
