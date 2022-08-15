import { ref } from '@vue/reactivity';
import axios from 'axios';


const updateAccount = () => {
    const account = ref({});
    const loading = ref(false);
    const accountError = ref({});


    const accountUpdated = async ({ form, id }) => {
        console.log(form)
        await axios.post('api/account/updateAccount/' + id, form, {
            headers: {
                Authorization: `Bearer ${localStorage.getItem('token')}`,
                Accept: 'application/json',
            }
        }).then((res) => {
            console.log(res.data);
            account.value = res.data;

        }).catch((resErr) => {
            accountError.value = resErr;
        })
    }
    return { account, accountError, accountUpdated }
}
export default updateAccount;
