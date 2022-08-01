import { ref } from '@vue/reactivity';
import axios from 'axios';
const updateUserDetails = () => {
    let user = ref({})
    const error = ref(null)

    const userUpdate = async (id, form) => {
        await axios.post('api/user/UpdateUserDetails/' + id, form, {
            headers: {
                Authorization: `Bearer ${localStorage.getItem('token')}`,
                Accept: 'application/json',
            }
        }).then((resUser) => {
            user.value = resUser.data;
            // console.log(user.value);
        }).catch((err) => {
            error.value = err.message;
        })
    }

    return { user, error, userUpdate }
}
export default updateUserDetails;
