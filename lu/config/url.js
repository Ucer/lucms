import env from './env'

const DEV_URL = 'http://lucms.test/'
const PRO_URL = 'http://lucms.test/'

export default env === 'development' ? DEV_URL : PRO_URL
