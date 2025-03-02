import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout'
import {Head, Link, useForm} from '@inertiajs/react'
import { useState } from 'react'

export default function Index({ seats, carriage, schedule_id }) {
    const { data, setData, post, processing } = useForm({
        seats: seats.data,
        train_schedule_id: schedule_id
    })

    const [searchQuery, setSearchQuery] = useState('')
    const [minPrice, setMinPrice] = useState('')
    const [maxPrice, setMaxPrice] = useState('')

    const handleReserve = seatId => {
        const updatedSeats = data.seats.map(seat =>
            seat.id === seatId ? { ...seat, is_reserved_for_date: true } : seat
        )

        setData('seats', updatedSeats)

        post(route('seats.reserve', { seat: seatId }), {
            data: { train_schedule_id: schedule_id },
            onError: () => {
                const revertedSeats = data.seats.map(seat =>
                    seat.id === seatId ? { ...seat, is_reserved_for_date: false } : seat
                )
                setData('seats', revertedSeats)
                alert('Не удалось забронировать место. Пожалуйста, попробуйте снова.')
            },
        })
    }

    const filteredSeats = data.seats.filter(seat => {
        const matchesQuery = seat.number
            .toLowerCase()
            .includes(searchQuery.toLowerCase())
        const matchesMinPrice = minPrice === '' || seat.price >= Number(minPrice)
        const matchesMaxPrice = maxPrice === '' || seat.price <= Number(maxPrice)

        return matchesQuery && matchesMinPrice && matchesMaxPrice
    })

    return (
        <AuthenticatedLayout>
            <Head title="Seats" />
            <div
                style={{
                    padding: '20px',
                    display: 'flex',
                    flexDirection: 'column',
                    alignItems: 'center'
                }}
            >
                <div style={{textAlign: 'center', marginBottom: '20px'}}>
                    <Link
                        href={route('carriages.seats.create', {
                            carriage: carriage.id
                        })}
                        style={{
                            padding: '10px 20px',
                            backgroundColor: '#007bff',
                            color: 'white',
                            textDecoration: 'none',
                            borderRadius: '5px',
                            fontSize: '16px'
                        }}
                    >
                        <span style={{marginRight: '5px'}}>+</span> Create
                        Seat
                    </Link>
                </div>
                {/* Фильтр поиска */}
                <div style={{marginBottom: '20px'}}>
                    <input
                        type="text"
                        placeholder="Search by seat number..."
                        value={searchQuery}
                        onChange={e => setSearchQuery(e.target.value)}
                        style={{
                            padding: '10px',
                            width: '310px',
                            marginBottom: '10px',
                            borderRadius: '5px',
                            border: '1px solid #ccc'
                        }}
                    />
                </div>

                {/* Фильтр по цене */}
                <div
                    style={{
                        display: 'flex',
                        gap: '10px',
                        justifyContent: 'center',
                        marginBottom: '20px'
                    }}
                >
                    <input
                        type="number"
                        placeholder="Min Price"
                        value={minPrice}
                        onChange={e => setMinPrice(e.target.value)}
                        style={{
                            padding: '10px',
                            width: '150px',
                            borderRadius: '5px',
                            border: '1px solid #ccc'
                        }}
                    />
                    <input
                        type="number"
                        placeholder="Max Price"
                        value={maxPrice}
                        onChange={e => setMaxPrice(e.target.value)}
                        style={{
                            padding: '10px',
                            width: '150px',
                            borderRadius: '5px',
                            border: '1px solid #ccc'
                        }}
                    />
                </div>

                {/* Список мест */}
                <div
                    style={{
                        display: 'flex',
                        flexWrap: 'wrap',
                        gap: '20px',
                        justifyContent: 'center'
                    }}
                >
                    {filteredSeats.map((seat, index) => (
                        <div
                            key={index}
                            style={{
                                textDecoration: 'none',
                                display: 'block',
                                border: '1px solid #ccc',
                                borderRadius: '8px',
                                padding: '20px',
                                minWidth: '200px',
                                textAlign: 'center',
                                backgroundColor: seat.is_reserved_for_date
                                    ? '#f8d7da'
                                    : '#d4edda',
                                boxShadow: '0 4px 6px rgba(0, 0, 0, 0.1)',
                                color: seat.is_reserved_for_date ? '#721c24' : '#155724'
                            }}
                        >
                            <h3 style={{marginBottom: '15px'}}>
                                Place {seat.number}
                            </h3>
                            <ul style={{listStyle: 'none', padding: 0}}>
                                <li style={{marginBottom: '10px'}}>
                                    <strong>ID:</strong> {seat.id}
                                </li>
                                <li style={{marginBottom: '10px'}}>
                                    <strong>Booked:</strong>{' '}
                                    {seat.is_reserved_for_date ? 'Yes' : 'No'}
                                </li>
                                <li style={{marginBottom: '10px'}}>
                                    <strong>Cost:</strong> {seat.price}$
                                </li>
                            </ul>

                            {!seat.is_reserved_for_date && (
                                <button
                                    onClick={() => handleReserve(seat.id)}
                                    disabled={processing}
                                    style={{
                                        padding: '10px 20px',
                                        backgroundColor: '#28a745',
                                        color: 'white',
                                        borderRadius: '5px',
                                        fontSize: '16px',
                                        border: 'none',
                                        cursor: processing
                                            ? 'not-allowed'
                                            : 'pointer'
                                    }}
                                >
                                    Book by {seat.price}$
                                </button>
                            )}
                        </div>
                    ))}
                </div>
            </div>
        </AuthenticatedLayout>
    )
}
