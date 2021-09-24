function page(path) {
  return () => import(/* webpackChunkName: '' */ `../pages/${path}`).then(m => m.default || m)
}

export default [

  { path: '*', name:'invalid-page', component: page('errors/page-not-found.vue') }, 
  // Login
  { path: '/login', name: 'login', component: page('auth/login.vue') },
  { path: '/', name: 'home', component: page('dashboard/dashboard.vue') },

  //Dashboard
  { path: '/dashboard', name: 'dashboard', component: page('dashboard/dashboard.vue') },

  //Branches
  { path: '/manage_branches', name: 'manage-branches', component: page('branches/manage_branches.vue') },
  { path: '/branches_inventory', name: 'branches-inventory', component: page('branches/branches_inventory.vue') },

  //Categories
  { path: '/supplies_category', name: 'supplies-category', component: page('categories/supplies_category.vue') },
  { path: '/products_category', name: 'products-category', component: page('categories/products_category.vue') },
  { path: '/products_sub_category', name: 'products-sub-category', component: page('categories/products_sub_category.vue') },

  //Inventory
  { path: '/masterlist_supplies', name: 'masterlist-supplies', component: page('inventory/masterlist_supplies.vue') },
  { path: '/incoming_supplies', name: 'incoming-supplies', component: page('inventory/incoming_supplies.vue') },
  { path: '/outgoing_supplies', name: 'outgoing-supplies', component: page('inventory/outgoing_supplies.vue') },
  { path: '/main_inventory', name: 'main-inventory', component: page('inventory/main_inventory.vue') },
  { path: '/inventory_summary', name: 'inventory-summary', component: page('inventory/inventory_summary.vue') },

  //Products
  { path: '/masterlist_products', name: 'masterlist-products', component: page('products/masterlist_products.vue') },
  { path: '/incoming_products', name: 'incoming-products', component: page('products/incoming_products.vue') },
  { path: '/outgoing_products', name: 'outgoing-products', component: page('products/outgoing_products.vue') },

  //Suppliers
  { path: '/suppliers_list', name: 'suppliers-list', component: page('suppliers/suppliers_list.vue') },
  { path: '/purchase_orders', name: 'purchase-orders', component: page('suppliers/purchase_orders.vue') },

  //Reports
  { path: '/reports', name: 'reports', component: page('reports/reports.vue') },

  //User Accounts
  { path: '/user_accounts', name: 'user-accounts', component: page('useraccounts/user_accounts.vue') },
  { path: '/user_roles', name: 'users-roles', component: page('user_roles.vue') },

  //Roles/Permissions
  { path: '/roles_permissions', name: 'roles-permissions', component: page('settings/roles_permissions.vue') },

  //POS
  { path: '/posmenu', name: 'pos', component: page('pos/posmenu.vue') },

  { path: '/auth/index', name: 'auth.index', component: page('auth/index.vue') },
  { path: '/template', name: 'template', component: page('template.vue') },
]