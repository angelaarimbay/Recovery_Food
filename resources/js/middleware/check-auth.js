import store from '~/store'

export default async (to, from, next) => {
  if (!store.getters['auth/check'] && store.getters['auth/token']) {
    try {
      await store.dispatch('auth/fetchUser')
      if (store.state.auth.user) {
          store.dispatch('auth/fetchUserPermissions')
          store.dispatch('auth/fetchUserRoles')
      }
      
    } catch (e) { }
  }

  next()
}
