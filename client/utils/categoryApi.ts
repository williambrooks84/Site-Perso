export async function getCategories(apiUrl: string) {
  const response = await fetch(`${apiUrl}/api/categories`, {
    headers: {
      Accept: 'application/json',
    },
    credentials: 'include',
  })

  if (!response.ok) {
    const data = await response.json().catch(() => null)

    throw new Error(
      data?.error || 'Impossible de charger les catégories.'
    )
  }

  return response.json()
}

export async function createCategory(
  name: string,
  apiUrl: string
) {
  const response = await fetch(
    `${apiUrl}/api/categories/submit`,
    {
      method: 'POST',
      headers: {
        Accept: 'application/json',
        'Content-Type': 'application/json',
      },
      credentials: 'include',
      body: JSON.stringify({
        name,
      }),
    }
  )

  const data = await response.json().catch(() => null)

  if (!response.ok) {
    throw new Error(
      data?.error || 'Impossible de créer la catégorie.'
    )
  }

  return data
}