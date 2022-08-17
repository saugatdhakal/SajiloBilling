import { ref } from '@vue/reactivity';
import axios from 'axios';

const forceDeleteSupplier = () => {
    const deletedSupplier = ref({});
    const loading = ref(false);
    const SupplierError = ref({});
    const deleteSupp = async (id) => {
        await axios.delete('api/supplier/forceDeleteSupplier/' + id, {
            headers: {
                Authorization: `Bearer ${localStorage.getItem('token')}`,
                Accept: 'application/json',
            }
        }).then((res) => {
            deletedSupplier.value = res.data;
        }).catch((resErr) => {
            SupplierError.value = resErr;
        })
    }
    return { deletedSupplier, SupplierError, deleteSupp }
}
export default forceDeleteSupplier;
