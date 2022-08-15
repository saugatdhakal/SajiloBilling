import { ref } from '@vue/reactivity';
import axios from 'axios';

const softDeleteAccount = () => {
    const accounts = ref({});
    const loading = ref(false);
    const accountError = ref({});
    const getAccounts = async ({page=1,paginate,search,selectedType}) => {
        await axios.get('api/account/softDeletes?page=' + page +
            '&paginate=' + paginate +
            '&q=' + search +
            '&selectedType=' + selectedType, {
            headers: {
                Authorization: `Bearer ${localStorage.getItem('token')}`,
                Accept: 'application/json',
            }
        }).then((res) => {
            accounts.value = res.data;
        }).catch((resErr) => {
            accountError.value = resErr;
        })
    }
    return { accounts, accountError, getAccounts }
}
export default softDeleteAccount;
