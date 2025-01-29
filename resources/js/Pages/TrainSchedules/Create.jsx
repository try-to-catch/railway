import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, useForm } from '@inertiajs/react';

export default function CreateTrip({ train }) {
    const { data, setData, post, processing, reset, errors } = useForm({
        train_id: train.id,
        departure: '',
        arrival: '',
    });

    const handleSubmit = (e) => {
        e.preventDefault();

        post(route('trains.trips.store', train.id), {
            onSuccess: () => {
                alert('Trip created successfully!');
                reset();
            },
            onError: () => {
                alert('Failed to create trip. Please check the input.');
            },
        });
    };

    return (
        <AuthenticatedLayout>
            <Head title="Add trip" />

            <div
                style={{
                    maxWidth: '600px',
                    margin: '20px auto',
                    padding: '20px',
                    border: '1px solid #ccc',
                    borderRadius: '8px',
                    backgroundColor: '#f8f9fa',
                }}
            >
                <h2 style={{ textAlign: 'center', marginBottom: '20px' }}>
                    Create Trip for Train {train.id}
                </h2>

                <form onSubmit={handleSubmit}>
                    {/* Carriage Number */}
                    <div style={{ marginBottom: '15px' }}>
                        <label
                            htmlFor="departure"
                            style={{ display: 'block', marginBottom: '5px' }}
                        >
                            Departure time:
                        </label>
                        <input
                            type="datetime-local"
                            id="departure"
                            value={data.departure}
                            onChange={(e) => setData('departure', e.target.value)}
                            style={{
                                width: '100%',
                                padding: '10px',
                                borderRadius: '4px',
                                border: '1px solid #ccc',
                            }}
                            required
                        />
                        {errors.departure && (
                            <div style={{ color: 'red', marginTop: '5px' }}>
                                {errors.departure}
                            </div>
                        )}
                    </div>

                    {/* Carriage Class */}
                    <div style={{ marginBottom: '15px' }}>
                        <label
                            htmlFor="arrival"
                            style={{ display: 'block', marginBottom: '5px' }}
                        >
                            Arrival time:
                        </label>
                        <input
                            type="datetime-local"
                            id="arrival"
                            value={data.arrival}
                            onChange={(e) => setData('arrival', e.target.value)}
                            style={{
                                width: '100%',
                                padding: '10px',
                                borderRadius: '4px',
                                border: '1px solid #ccc',
                            }}
                            required
                        />
                        {errors.arrival && (
                            <div style={{ color: 'red', marginTop: '5px' }}>
                                {errors.arrival}
                            </div>
                        )}
                    </div>

                    {/* Submit Button */}
                    <button
                        type="submit"
                        disabled={processing}
                        style={{
                            display: 'block',
                            width: '100%',
                            padding: '10px',
                            backgroundColor: '#007bff',
                            color: '#fff',
                            border: 'none',
                            borderRadius: '4px',
                            cursor: processing ? 'not-allowed' : 'pointer',
                        }}
                    >
                        {processing ? 'Creating...' : 'Create Trip'}
                    </button>
                </form>
            </div>
        </AuthenticatedLayout>
    );
}
