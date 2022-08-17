import { ref } from '@vue/reactivity';
import axios from 'axios';

const softDeleteSupplier = () => {
    const deletedSupplier = ref({});
    const loading = ref(true);
    const supplierError = ref({});
    const softDelete = async (id) => {
        await axios.delete('api/supplier/supplierSoftDelete/' + id, {
            headers: {
                Authorization: `Bearer ${localStorage.getItem('token')}`,
                Accept: 'application/json',
            }
        }).then((res) => {
            loading.value = false;
            deletedSupplier.value = res.data;
            console.log(res)
        }).catch((resErr) => {
            loading.value = false;
            supplierError.value = resErr;
        })
    }
    return { deletedSupplier, loading, supplierError, softDelete }
}
export default softDeleteSupplier;
