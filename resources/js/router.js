import VueRouter from "vue-router";
import Vue from "vue";

import LoginComponent from "./components/auth/LoginComponent.vue";
import RegisterComponent from "./components/auth/RegisterComponent.vue";

import ListContactsComponent from "./components/contacts/ListContactsComponent.vue";
import ListFavoritesComponent from "./components/contacts/ListFavoritesComponent.vue";

import EditContactComponent from "./components/contacts/EditContactComponent.vue";
import ViewContactComponent from "./components/contacts/ViewContactComponent.vue";
import AddContactComponent from "./components/contacts/AddContactComponent.vue";

Vue.use(VueRouter);

const router = new VueRouter({
    mode: "history",
    routes: [
        {
            path: "/favorites",
            name: "favorites",
            component: ListFavoritesComponent
        },
        {
            path: "/contacts",
            name: "contacts",
            component: ListContactsComponent
        },
        {
            path: "/contact/:id/edit",
            name: "contact_edit",
            component: EditContactComponent
        },
        {
            path: "/contact/:id/view",
            name: "contact_view",
            component: ViewContactComponent,
            props: true
        },
        {
            path: "/contact/create",
            name: "contact_create",
            component: AddContactComponent
        },
        {
            path: "/login",
            name: "login",
            component: LoginComponent
        },
        {
            path: "/register",
            name: "register",
            component: RegisterComponent
        }
    ]
});

router.beforeEach((to, from, next) => {
    let accessToken = localStorage.getItem("token");
    if (accessToken == null && to.fullPath !== "/login") {
        next("/login");
    }
    next();
});

export default router;
