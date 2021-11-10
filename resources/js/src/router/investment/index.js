export default [
  {
    path: '/investment/new',
    name: 'create-investment',
    component: () => import('@/views/pages/investment/Create.vue'),
    meta: {
      pageTitle: 'Create Investment',
      breadcrumb: [
        {
          text: 'Create Investment',
          active: true,
        },
      ],
    },
  },
  {
    path: '/investment/edit',
    name: 'edit-investment',
    component: () => import('@/views/pages/investment/Edit.vue'),
    meta: {
      pageTitle: 'Edit Investment',
      breadcrumb: [
        {
          text: 'Edit Investment',
          active: true,
        },
      ],
    },
  },
  {
    path: '/investments',
    name: 'list-investment',
    component: () => import('@/views/pages/investment/List.vue'),
    meta: {
      pageTitle: 'Investments',
      breadcrumb: [
        {
          text: 'Investments',
          active: true,
        },
      ],
    },
  },
]
