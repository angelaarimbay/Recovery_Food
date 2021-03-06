function page (path) {
    return () => import(/* webpackChunkName: '' */ `../pages/${path}`).then(m => m.default || m)
  }

export default{
    mode: 'history',
    routes:[ 
        { path:'*', component: page('errors/page-not-found.vue') }, 
        { path:'/',  component: page('login.vue') },  
        { path:'/login', name: 'login', component: page('login.vue') },  
        { path:'/dashboard', name: 'dashboard', component: page('dashboard.vue') },  

        { path:'/survey/infosheet', name: 'survey.infosheet', component: page('survey/infosheet.vue') }, 
        { path:'/accumulation', name: 'accumulation', component: page('maps/accumulation.vue') }, 
        { path:'/maps/googlemap', name: 'maps.googlemap', component: page('maps/googlemap.vue') }, 
        { path:'/auth/index', name: 'auth.index', component: page('auth/index.vue') }, 

    ]
}