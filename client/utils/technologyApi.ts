export async function getTechnologies(apiUrl: string) {
  const response = await fetch(`${apiUrl}/api/technologies`, {
    headers: {
      Accept: 'application/json',
    },
    credentials: 'include',
  })

  if (!response.ok) {
    const data = await response.json().catch(() => null)

    throw new Error(
      data?.error || 'Impossible de charger les technologies.'
    )
  }

  return response.json()
}

export async function createTechnology(
  name: string,
  icon: File,
  apiUrl: string
) {
  const formData = new FormData()

  formData.append('description', name)
  formData.append('image', icon)

  const response = await fetch(
    `${apiUrl}/api/technologies/submit`,
    {
      method: 'POST',
      headers: {
        Accept: 'application/json',
      },
      credentials: 'include',
      body: formData,
    }
  )

  const data = await response.json().catch(() => null)

  if (!response.ok) {
    throw new Error(
      data?.error || 'Impossible de créer la technologie.'
    )
  }

  return data
}

export async function deleteTechnology(
  technologyId: number | string,
  apiUrl: string
) {
  const response = await fetch(
    `${apiUrl}/api/technologies/delete?id=${technologyId}`,
    {
      method: 'DELETE',
      headers: {
        Accept: 'application/json',
      },
      credentials: 'include',
    }
  )

  const data = await response.json().catch(() => null)

  if (!response.ok) {
    throw new Error(
      data?.error || 'Impossible de supprimer la technologie.'
    )
  }

  return data
}