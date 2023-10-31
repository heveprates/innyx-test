// Composables
import { RouterOptions, createRouter, createWebHistory } from "vue-router";

const routes: RouterOptions["routes"] = [
  {
    path: "/",
    component: () => import("@/layouts/default/Default.vue"),
    children: [
      {
        path: "",
        redirect: "/product",
      },
      {
        path: "product",
        name: "Product",
        children: [
          {
            path: "",
            name: "ProductList",
            component: () => import("@/views/Product/ProductList.vue"),
          },
          {
            path: "add",
            name: "ProductAdd",
            component: () => import("@/views/Product/ProductAdd.vue"),
          },
          {
            path: "edit/:id",
            name: "ProductEdit",
            component: () => import("@/views/Product/ProductEdit.vue"),
          },
        ],
      },
      {
        path: "category",
        name: "Category",
        children: [
          {
            path: "",
            name: "CategoryList",
            component: () => import("@/views/Category/CategoryList.vue"),
          },
          {
            path: "add",
            name: "CategoryAdd",
            component: () => import("@/views/Category/CategoryAdd.vue"),
          },
          {
            path: "edit/:id",
            name: "CategoryEdit",
            component: () => import("@/views/Category/CategoryEdit.vue"),
          },
        ],
      },
    ],
  },
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

export default router;
