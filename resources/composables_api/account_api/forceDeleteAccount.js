import { ref } from '@vue/reactivity';
import axios from 'axios';

const forceDeleteAccount = () => {
    const deletedAccount = ref({});
    const loading = ref(false);
    const accountError = ref({});
    const deleteAcc = async (id) => {
        await axios.delete('api/account/forceDeleteAccount/' + id, {
            headers: {
                Authorization: `Bearer ${localStorage.getItem('token')}`,
                Accept: 'application/json',
            }
        }).then((res) => {
            deletedAccount.value = res.data;
        }).catch((resErr) => {
            accountError.value = resErr;
        })
    }
    return { deletedAccount, accountError, deleteAcc }
}
export default forceDeleteAccount;
