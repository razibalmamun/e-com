export default function ({ app, $auth}) {
    $auth.onRedirect((to, from) => {
        let urlSplit = to.split("/");
        let findLocal = app.i18n.locales.find(locale => locale.code == urlSplit[0] || locale.code == urlSplit[1] )
        if(findLocal){
            return to;
        }else{
            return app.localePath(to);
        }
    })
}