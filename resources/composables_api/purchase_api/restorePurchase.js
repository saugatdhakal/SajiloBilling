import { ref } from '@vue/reactivity';
import axios from 'axios';

const restoreTrashPurchase = () => {
    const restoredPurchase = ref({});
    const loading = ref(true);
    const restorePurchaseError = ref({});
    const restore = async (id) => {
        await axios.post('api/purchase/restore/' + id, '', {
            headers: {
                Authorization: `Bearer ${localStorage.getItem('token')}`,
                Accept: 'application/json',
            }
        }).then((res) => {
            loading.value = false;
            restoredPurchase.value = res.data;
        }).catch((resErr) => {
            loading.value = false;
            restorePurchaseError.value = resErr;
        })
    }
    return { restoredPurchase, loading, restorePurchaseError, restore }
}
export default restoreTrashPurchase;
