export default function ({ app, $axios, $config }) {
    app.i18n.onLanguageSwitched = (oldLocale, newLocale) => {
        $axios.setBaseURL($config.remoteBaseUrl + '/api/' + newLocale);
    }
}
