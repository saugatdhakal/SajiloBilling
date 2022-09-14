const register = (app) => {
    const components = import.meta.globEager(
        '../components/Base*.vue'
    );
    Object.entries(components).forEach(([path, component]) => {
        // Just get the file name itself, remove the .vue extension, and remove the "Base" at the front of the file name
        const pathSplit = path.split('/')
        const fileName = pathSplit[pathSplit.length - 1].split('.vue')[0].split('Base')[1]

        // Convert to kebab-case and register with a "jvp-" prefix
        const kebab = fileName.replace(/([a-z0-9])([A-Z])/g, '$1-$2').toLowerCase()
        app.component(`base-${kebab}`, component.default)
    })
}
export default register;
