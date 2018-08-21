import Main from '@/view/main'
import parentView from '@/components/parent-view'

export default[
  {
    path: '/login',
    name: 'login',
    meta: {
      title: 'Login - 登录',
      hideInMenu: true
    },
    component: () => import ('@/view/login/login.vue')
  }, {
    path: '/',
    name: '_home',
    redirect: '/home',
    component: Main,
    meta: {
      hideInMenu: true,
      notCache: true
    },
    children: [
      {
        path: '/home',
        name: 'home',
        meta: {
          hideInMenu: true,
          title: '首页',
          notCache: true
        },
        component: () => import ('@/view/single-page/home')
      }
    ]
  }, {
    path: '/privileges',
    name: 'privileges',
    component: Main,
    meta: {
      icon: 'ios-key',
      title: '权限管理',
      access: ['Founder']
    },
    children: [
      {
        path: '/permission-list',
        name: 'permission-list',
        meta: {
          icon: 'ios-lock',
          title: '权限列表'
        },
        component: () => import ('@/view/privileges/permissions/list.vue')
      }, {
        path: '/role-list',
        name: 'role-list',
        meta: {
          icon: 'ios-people',
          title: '角色列表',
          // href: 'https://lison16.github.io/iview-admin-doc/#/'
        },
        component: () => import ('@/view/privileges/roles/list.vue')
      }, {
        path: '/administrator-list',
        name: 'administrator-list',
        meta: {
          icon: 'md-people',
          title: '用户列表'
        },
        component: () => import ('@/view/privileges/users/list.vue')
      }
    ]
  }, {
    path: '/news-system',
    name: 'news-system',
    component: Main,
    meta: {
      title: '新闻系统',
      icon: 'ios-cog'
    },
    children: [
      {
        path: '/advertisement-positions',
        name: 'advertisement-positions',
        meta: {
          icon: 'ios-disc',
          title: '广告位'
        },
        component: () => import ('@/view/news-system/advertisement-positions/list.vue')
      }, {
        path: 'advertisement-list',
        name: 'advertisement-list',
        meta: {
          icon: 'ios-volume-up',
          title: '广告列表'
        },
        component: () => import ('@/view/news-system/advertisements/list.vue')
      }, {
        path: '/category-list',
        name: 'category-list',
        meta: {
          icon: 'ios-navigate',
          title: '分类管理'
        },
        component: () => import ('@/view/news-system/categories/list.vue')
      }, {
        path: '/tag-list',
        name: 'tag-list',
        meta: {
          icon: 'ios-pricetags',
          title: '标签管理'
        },
        component: () => import ('@/view/news-system/tags/list.vue')
      }, {
        path: '/article-list',
        name: 'article-list',
        meta: {
          icon: 'ios-list',
          title: '文章管理'
        },
        component: () => import ('@/view/news-system/articles/list.vue')
      }
    ]
  }, {
    path: '/401',
    name: 'error_401',
    meta: {
      hideInMenu: true
    },
    component: () => import ('@/view/error-page/401.vue')
  }, {
    path: '/500',
    name: 'error_500',
    meta: {
      hideInMenu: true
    },
    component: () => import ('@/view/error-page/500.vue')
  }, {
    path: '*',
    name: 'error_404',
    meta: {
      hideInMenu: true
    },
    component: () => import ('@/view/error-page/404.vue')
  }
]
