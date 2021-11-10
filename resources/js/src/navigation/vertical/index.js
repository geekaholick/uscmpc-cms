export default [
  {
    title: 'Home',
    route: 'home',
    icon: 'HomeIcon',
  },
  {
    title: 'Investment',
    icon: 'EditIcon',
    children: [
      {
        title: 'Investments',
        route: 'list-investment',
        icon: 'ListIcon',
      }
    ]
  },
]
