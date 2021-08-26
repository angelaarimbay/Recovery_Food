function page(path) {
    return () => import(/* webpackChunkName: '' */ `../pages/${path}`).then(m => m.default || m)
}

export default {
    mode: 'history',
    routes: [
        // { path:'*', component: page('errors/page-not-found.vue') }, 
        // { path:'/',  component: page('login.vue') },  
        { path: '/', name: 'dashboard', component: page('dashboard.vue') },
        { path: '/dashboard', name: 'dashboard', component: page('dashboard.vue') },
        { path: '/manage_branches', name: 'branches', component: page('manage_branches.vue') },
        { path: '/branches_info', name: 'branches', component: page('branches_info.vue') },
        { path: '/branches_inventory', name: 'branches', component: page('branches_inventory.vue') },
        { path: '/supplies_category', name: 'categories', component: page('supplies_category.vue') },
        { path: '/products_category', name: 'categories', component: page('products_category.vue') },
        { path: '/products_sub_category', name: 'categories', component: page('products_sub_category.vue') },

        { path: '/survey/infosheet', name: 'survey.infosheet', component: page('survey/infosheet.vue') },
        { path: '/accumulation', name: 'accumulation', component: page('maps/accumulation.vue') },
        { path: '/maps/googlemap', name: 'maps.googlemap', component: page('maps/googlemap.vue') },
        { path: '/auth/index', name: 'auth.index', component: page('auth/index.vue') },

        { path: '/template', name: 'template', component: page('template.vue') },

    ]
}