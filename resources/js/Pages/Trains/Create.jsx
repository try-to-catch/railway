import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {Head} from '@inertiajs/react';

export default function Show() {
    return (
        <AuthenticatedLayout>
            <Head title="Create Train"/>

            Create Train
        </AuthenticatedLayout>
    );
}
