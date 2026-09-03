import { beforeEach, describe, expect, it, vi } from 'vitest'
import { createProject } from '../utils/projectApi'

describe('createProject', () => {
  beforeEach(() => {
    vi.restoreAllMocks()
  })

  it('posts a project payload to the API and returns the created data', async () => {
    const created = { id: 1, title: 'Mon projet', description: 'Description' }
    const fetchMock = vi.fn().mockResolvedValue({
      ok: true,
      json: async () => created,
    })

    vi.stubGlobal('fetch', fetchMock)

    const result = await createProject({
      title: 'Mon projet',
      description: 'Description',
    })

    expect(fetchMock).toHaveBeenCalledWith(
      'http://localhost:8000/api/projects',
      expect.objectContaining({
        method: 'POST',
        headers: {
          'Content-Type': 'application/ld+json',
          Accept: 'application/ld+json',
        },
        body: JSON.stringify({
          title: 'Mon projet',
          description: 'Description',
        }),
      })
    )

    expect(result).toEqual(created)
  })
})
