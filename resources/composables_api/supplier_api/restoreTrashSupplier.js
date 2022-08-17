import { ref } from '@vue/reactivity';
import axios from 'axios';

const restoreTrashSupplier = () => {
    const restoreSupplier = ref({});
    const loading = ref(true);
    const supplierError = ref({});
    const restore = async (id) => {
        await axios.post('api/supplier/restoreSuppliers/' + id,'', {
            headers: {
                Authorization: `Bearer ${localStorage.getItem('token')}`,
                Accept: 'application/json',
            }
        }).then((res) => {
            loading.value = false;
            restoreSupplier.value = res.data;
        }).catch((resErr) => {
            loading.value = false;
            supplierError.value = resErr;
        })
    }
    return { restoreSupplier, loading, supplierError, restore }
}
export default restoreTrashSupplier;
