import store from '~/store'

export default (to, from, next) => {
  if (store.getters['auth/user_roles']['Super Admin'] || store.getters['auth/user_roles']['User Manager']) {
    next()
  } else {
    next({ name: 'home' })
  }
}
