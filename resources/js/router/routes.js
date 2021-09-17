function page(path) {
    return () => import(/* webpackChunkName: '' */ `../pages/${path}`).then(m => m.default || m)
}

export default {
    mode: 'history',
    routes: [
        // Login
        { path: '/login', name: 'login', component: page('login.vue') },

        // { path:'*', component: page('errors/page-not-found.vue') }, 
        // { path:'/',  component: page('login.vue') },  
        { path: '/', name: 'dashboard', component: page('dashboard.vue') },

        //Dashboard
        { path: '/dashboard', name: 'dashboard', component: page('dashboard.vue') },

        //Branches
        { path: '/manage_branches', name: 'branches', component: page('manage_branches.vue') },
        { path: '/branches_inventory', name: 'branches', component: page('branches_inventory.vue') },

        //Categories
        { path: '/supplies_category', name: 'categories', component: page('supplies_category.vue') },
        { path: '/products_category', name: 'categories', component: page('products_category.vue') },
        { path: '/products_sub_category', name: 'categories', component: page('products_sub_category.vue') },

        //Inventory
        { path: '/masterlist_supplies', name: 'inventory', component: page('masterlist_supplies.vue') },
        { path: '/incoming_supplies', name: 'inventory', component: page('incoming_supplies.vue') },
        { path: '/outgoing_supplies', name: 'inventory', component: page('outgoing_supplies.vue') },
        { path: '/main_inventory', name: 'inventory', component: page('main_inventory.vue') },
        { path: '/inventory_summary', name: 'inventory', component: page('inventory_summary.vue') },

        //Products
        { path: '/products_list', name: 'products', component: page('products_list.vue') },
        { path: '/outgoing_products', name: 'products', component: page('outgoing_products.vue') },

        //Suppliers
        { path: '/suppliers_list', name: 'suppliers', component: page('suppliers_list.vue') },
        { path: '/purchase_orders', name: 'suppliers', component: page('purchase_orders.vue') },

        //Reports
        { path: '/reports', name: 'reports', component: page('reports.vue') },

        //User Accounts
        { path: '/user_accounts', name: 'users', component: page('user_accounts.vue') },
        { path: '/user_roles', name: 'users.roles', component: page('user_roles.vue') },

        //Roles/Permissions
        { path: '/roles_permissions', name: 'users', component: page('roles_permissions.vue') },

        { path: '/survey/infosheet', name: 'survey.infosheet', component: page('survey/infosheet.vue') },
        { path: '/accumulation', name: 'accumulation', component: page('maps/accumulation.vue') },
        { path: '/maps/googlemap', name: 'maps.googlemap', component: page('maps/googlemap.vue') },
        { path: '/auth/index', name: 'auth.index', component: page('auth/index.vue') },

        { path: '/template', name: 'template', component: page('template.vue') },
    ]
}