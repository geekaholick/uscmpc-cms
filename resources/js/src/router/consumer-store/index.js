export default [
  {
    path: '/banner/new',
    name: 'create-consumerstore',
    component: () => import('@/views/pages/consumer-store/Create.vue'),
    meta: {
      pageTitle: 'Create Consumer Store',
      breadcrumb: [
        {
          text: 'Create Consumer Store',
          active: true,
        },
      ],
    },
  },
  {
    path: '/banners',
    name: 'list-consumerstore',
    component: () => import('@/views/pages/consumer-store/List.vue'),
    meta: {
      pageTitle: 'Consumer Store List',
      breadcrumb: [
        {
          text: 'Consumer Store List',
          active: true,
        },
      ],
    },
  },

  {
    path: '/banner/edit',
    name: 'edit-consumerstore',
    component: () => import('@/views/pages/consumer-store/Edit.vue'),
    meta: {
      pageTitle: 'Consumer Store Edit',
      breadcrumb: [
        {
          text: 'Consumer Store Edit',
          active: true,
        },
      ],
    },
  }
]
