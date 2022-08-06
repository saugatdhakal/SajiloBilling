import { ref } from '@vue/reactivity';
import axios from 'axios';

const AccountDelete = () => {
    const deletedAccount = ref({});
    const loading = ref(false);
    const accountError = ref({});
    const softDelete = async (id) => {
        await axios.delete('api/account/softDelete/' + id, {
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
    return { deletedAccount, accountError, softDelete }
}
export default AccountDelete;
