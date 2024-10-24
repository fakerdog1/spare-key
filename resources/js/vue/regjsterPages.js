const registerRoutePages = (app, pages) => {
  Object.entries(pages).forEach(([path, definition]) => {
    const pageName = path.split('/').pop().replace(/\.\w+$/, '')

    if (definition.default?.name) {
      app.component(definition.default.name, definition.default)
    } else {
      app.component(pageName, definition.default)
    }
  })
}

const registerPages = (app) => {
  const contentPages = import.meta.glob('./content/*.vue', { eager: true })
  const componentPages = import.meta.glob('./components/*.vue', { eager: true })

  registerRoutePages(app, contentPages)
  registerRoutePages(app, componentPages)
}

export default registerPages
