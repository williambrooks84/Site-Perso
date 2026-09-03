export type ProjectPayload = {
  title: string
  description: string
  projectLink?: string
  siteLink?: string
  image?: File | null
}

export async function createProject(
  payload: ProjectPayload,
  apiUrl: string
) {
  const formData = new FormData()
  formData.append('title', payload.title)
  formData.append('description', payload.description)
  if (payload.projectLink) formData.append('projectLink', payload.projectLink)
  if (payload.siteLink) formData.append('siteLink', payload.siteLink)
  if (payload.image) formData.append('image', payload.image, payload.image.name)

  const response = await fetch(`${apiUrl}/api/projects/upload`, {
    method: 'POST',
    headers: { Accept: 'application/json' },
    body: formData,
  })

  if (!response.ok) {
    const errorText = await response.text().catch(() => '')
    let message = errorText

    try {
      const error = JSON.parse(errorText)
      message = error.error || errorText
    } catch {
      // Keep the raw response when the API does not return JSON.
    }

    throw new Error(message || `Erreur API (${response.status})`)
  }

  return response.json()
}
