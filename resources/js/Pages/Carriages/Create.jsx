import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {Head} from '@inertiajs/react';

export default function Show({trains}) {
    return (
        <AuthenticatedLayout>
            <Head title="Create Carriage"/>

            Create Carriage
        </AuthenticatedLayout>
    );
}
