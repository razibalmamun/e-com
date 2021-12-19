export default function ({ app, $axios, $config }) {
    
    $axios.setBaseURL($config.remoteBaseUrl + '/api/' + app.i18n.locale);
    
    $axios.interceptors.response.use((response) => {
        return response;
    }, (error) => {
        if (error.response && error.response.data) {
            if(error.response.status===403){
                // to redirect to nuxt 401 error page
                return $nuxt.error({ statusCode: 401, message: error.response.data.error });
            }
            return Promise.reject(error);
        }
        return Promise.reject(error);
    });
}
