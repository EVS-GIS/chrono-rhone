import { required, confirmed, email, min, max, numeric, regex, mimes } from "vee-validate/dist/rules"
import { extend } from "vee-validate"

extend("required", required)
extend("confirmed", confirmed)
extend("email", email)
extend("min", min)
extend("max", max)
extend("numeric", numeric)
extend("regex", regex)
extend("mimes", mimes)